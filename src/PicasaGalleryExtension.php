<?php

namespace Bolt\Extension\Bveldhuis\PicasaGallery;

use Bolt\Application;
use \Bolt\Extension\SimpleExtension;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PicasaGalleryExtension extends SimpleExtension {

    const NAME = 'PicasaGallery';

    protected function registerTwigFunctions() {
        return [
            'picasaAlbums' => 'twigPicasaAlbums',
            'picasaPhotos' => 'twigPicasaPhotos'
        ];
    }

    protected function registerFrontendRoutes(ControllerCollection $collection) {
        $collection->match('/photos/{albumID}', [$this, 'showPicasaAlbum']);
    }

    public function showPicasaAlbum(Application $app, Request $request, $albumID) {
        return new Response($this->twigPicasaPhotos($albumID));
    }

    /**
     * Render the list of albums
     */
    public function twigPicasaAlbums() {
        $config = $this->getConfig();

        if ($config['picasa_username'] == '') {
            error_log("[Bolt/" . PicasaGalleryExtension::NAME . "] Picasa username not configured");
            return;
        }

        $albums = array();

        try {
            $xml = @simplexml_load_file("https://picasaweb.google.com/data/feed/base/user/" . $config['picasa_username'] . "?kind=album&alt=rss&hl=nl&access=public");

            if ($xml) {
                foreach ($xml->channel->item as $item) {
                    //From XML: <pubDate>Sun, 15 Aug 2010 07:00:00 +0000</pubDate>
                    $pubDate = strtotime(trim($item->pubDate));
                    $title = trim($item->title);

                    preg_match("/albumid\/(.*)\?/", $item->guid, $albumID);
                    $albumID = $albumID[1];

                    $thumbnail = strip_tags($item->description, "<img>");
                    preg_match("/src=\"(.*)\" /", $thumbnail, $thumbnail);
                    $thumbnail = substr($thumbnail[0], 5);
                    $thumbnail = substr($thumbnail, 0, -2);

                    $album = array(
                        "albumID" => $albumID,
                        "thumb" => $thumbnail,
                        "title" => $title,
                        "pubDate" => $pubDate
                    );

                    array_push($albums, $album);
                }
            } else {
                error_log("[Bolt/" . PicasaGalleryExtension::NAME . "] Error loading albums from Picasa: no valid XML response");
                echo $config['error_message'] . "\n";
                return;
            }
        } catch (Exception $e) {
            error_log("[Bolt/" . PicasaGalleryExtension::NAME . "] Error loading albums from Picasa : " . $e->getMessage());
            echo $config['error_message'] . "\n";
            return;
        }

        $template = $config['template_albums_list'];
        return $this->renderTemplate($template, array('albums' => $albums));
    }

    /**
     * Render the photo-gallery for one album
     */
    private function twigPicasaPhotos($albumID) {
        $config = $this->getConfig();

        if ($config['picasa_username'] == '') {
            error_log("[Bolt/" . PicasaGalleryExtension::NAME . "] Picasa username not configured");
            return;
        }
        if ($albumID == '') {
            error_log("[Bolt/" . PicasaGalleryExtension::NAME . "] Picasa albumID not provided");
            return;
        }

        $photos = array();

        try {
            $albumUrl = "https://picasaweb.google.com/data/feed/base/user/" . $config['picasa_username'] . "/albumid/" . $albumID . "?alt=rss&amp;hl=nl&kind=photo";
            $xml = @simplexml_load_file($albumUrl);

            if ($xml) {
                $albumTitle = $xml->channel->title;
                $albumThumb = $xml->channel->image->url;

                foreach ($xml->channel->item as $item) {

                    $title = trim($item->title);

                    $thumbnail = strip_tags($item->description, "<img>");
                    preg_match("/src=\"(.*)\" /", $thumbnail, $thumbnail);
                    $thumbnail = $thumbnail[1];

                    $url = $item->enclosure["url"];

                    $attributes = $item->children('http://search.yahoo.com/mrss/')->group->content->attributes();
                    $width = $attributes["width"];
                    $height = $attributes["height"]; 
                    
                    // Force all connections over secure https
                    $thumbnail = str_replace("http://", "https://", $thumbnail);
                    $url = str_replace("http://", "https://", $url);

                    $photo = array(
                        "url" => $url,
                        "thumb" => $thumbnail,
                        "title" => $title,
                        "width" => $width,
                        "height" => $height
                    );

                    array_push($photos, $photo);
                }
            } else {
                error_log("[Bolt/" . PicasaGalleryExtension::NAME . "] Error loading photos from Picasa: no valid XML response");
                echo $config['error_message'] . "\n";
                return;
            }
        } catch (Exception $e) {
            error_log("[Bolt/" . PicasaGalleryExtension::NAME . "] Error loading photos from Picasa : " . $e->getMessage());
            echo $config['error_message'] . "\n";
            return;
        }

        $template = $config['template_album_photos'];
        return $this->renderTemplate($template, array(
                    'albumID' => $albumID,
                    'title' => $albumTitle,
                    'thumb' => $albumThumb,
                    'photos' => $photos
        ));
    }

}
