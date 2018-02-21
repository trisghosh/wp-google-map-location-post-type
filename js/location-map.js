"use strict";
if(lat=='' || lat==null )
{
	var lat="51.508742";
	
}
if(long=='' || long==null)
{
	var long="-0.120850";
}
var myCenter=new google.maps.LatLng(lat,long);
function initialize()
{
  var mapProp = 
  {
    center: myCenter,
    zoom:5,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker = new google.maps.Marker({
  position: myCenter,
draggable: true,
  title:'Click to zoom'
  });

marker.setMap(map);
google.maps.event.addListener(marker, 'click', function (event) {
    document.getElementById("latlngbox").value = event.latLng.lat()+','+event.latLng.lng();
 
});

google.maps.event.addListener(marker, 'click', function (event) {
    document.getElementById("latlngbox").value = this.getPosition().lat()+','+this.getPosition().lng();
 
});

google.maps.event.addListener(marker, 'dragend', function (event) {
    document.getElementById("latlngbox").value = this.getPosition().lat()+','+this.getPosition().lng();
 
});

}
google.maps.event.addDomListener(window, 'load', initialize);
