# Bolt.cm Flickr Image Gallery Extension #

A basic extension displaying a simple image gallery, based on a user public Flickr images.

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

### Layout Parameters ###
* __images_container__ : HTML tag you want for the  global images container, defaults to UL
* __images_container_class__ : 'class' attribute for the global images container 
* __image_container__ : HTML tag you want for each image container, defaults to LI
* __image_container_class__ : 'class' attribute for each image container
* __title_container__ : HTML tag you want for each title container. Empty = no title
* __title_container_class__ : 'class' attribute for each title container

*Mandatory fields

Note that container tags (wrapper, image & title) can be cascaded using commas, and so are classes. This means that images_container could be 'div,ul' and images_containe_class 'big-wrapper,wrapper'. As a result, you will get the following HTML code :

    <div class="big-wrapper">
        <ul class="wrapper">
        </ul>
    </div>

And if it doesn't fit your needs, just go with your own template.

### Other Parameters ###
* __show_link__ : true/false to display flickr link to the image or not
* __error_message__ : Message to be displayed in case of loading error

*Mandatory fields
