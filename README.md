# Bolt.cm Picasa Image Gallery Extension #

A basic extension displaying an image gallery, based on a user public Picasaweb images.

Just add the following twig function in your template to display the gallery: 

    For the list of albums: {% autoescape false %}{{ picasaAlbums() }}{% endautoescape %}
	
	Configure the template for the album photos and create your own twig-view to show all photos in one album. 

## Configuration ##

After installation, just edit the newly created picasagallery.bveldhuis.yml configuration file in your app/config/extensions folder with the following parameters:
 
### Settings ###
* __picasa_username__: Your Picasaweb username
* __template_albums_list__: path to your template for the album list, relative to your theme path
* __template_album_photos__: path to your template for the photos within an album
* __error_message__: Message to be displayed in case of loading error
