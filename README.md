# Bolt.cm Flickr Image Gallery Extension #

A basic extension displaying an image gallery, based on a user public Flickr images.

I needed it for a personnal project, but it might help someone out there sometime.

Just add the following twig function in your template to display the gallery : 

    {{ flickrgallery() }}

## Configuration ##

After installation, just edit the newly created flickrgallery.breizhtorm.yml configuration file in your app/config/extensions folder with the following parameters :
 
### Flickr Parameters ###
* __flickr_api_key__* : Your Flickr API key (you can get one here https://www.flickr.com/services/apps/create/apply/)
* __flickr_secret__* : Your Flickr Secret
* __flickr_user_id__* : The user id you want the public images to be displayed
* __flickr_image_size__ : see https://www.flickr.com/services/api/misc.urls.html, defaults to 'q'
* __flickr_image_count__ : number of images you wan in the gallery

*Mandatory fields

### Other Parameters ###
* __template__* : path to your gallery template, relative to your theme path
* __error_message__ : Message to be displayed in case of loading error

*Mandatory fields

## Notes ##

In 2.0, the gallery layout management changed to something a bit more simple and developer friendly. So when upgrading to 2.X, pay attention to add your own gallery template (if needed).
