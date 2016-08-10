# Bolt.cm Picasa Image Gallery Extension #

* NOTE: Currently only the album list is working!

A basic extension displaying an image gallery, based on a user public Picasaweb images.

Just add the following twig function in your template to display the gallery: 

    For the list of albums: {% autoescape false %}{{ picasaAlbums() }}{% endautoescape %}
	
	To show all photos in one album: {% autoescape false %}{{ picasaPhotos(albumID) }}{% endautoescape %}

## Configuration ##

After installation, just edit the newly created picasagallery.bveldhuis.yml configuration file in your app/config/extensions folder with the following parameters:
 
### Settings ###
* __picasa_username__: Your Picasaweb username
* __template_albums_list__: path to your template for the album list, relative to your theme path
* __template_album_photos__: path to your template for the photos within an album, relative to your theme path
* __error_message__: Message to be displayed in case of loading error
