var bcpActiveTab={};
var bcpExistsTabs=["bcpAddNewBackup",'bcpAllBackups','bcpPluginSettings'];
var  bcpMapConstructParams={
             mapContainerId:"mapPreviewToNewMap"
     };
var nochange = false;     

 var def_tab_elem;




function bcpChangeTab(elem,sub){
    var tabId;
    
    try{
        tabId = elem.attr("href");
    }catch(e){
        tabId = elem;
    }
   
//    if(bcpActiveTab.mainmenu=="#bcpEditMaps" && tabId!="#bcpEditMaps" && sub==undefined){
//        bcpCancelMapEdit({changeTab:false});
//    }
//  
//    if(bcpActiveTab.mainmenu=="#bcpAddNewMap" && tabId!="#bcpAddNewMap" && sub==undefined){
//        if(bcpIsMapFormIsEditing()){
//            if(confirm("If you leave tab,all information will be lost. \n Leave tab?")){
//               return false; 
//            }else{
//                clearAddNewMapData();
//                clearMarkerForm();
//            }
//        }
//    }
//    
    
//    if(sub!= undefined){
//       bcpActiveTab.submenu=tabId; 
//    }else{
//        if(tabId=="#bcpAddNewMap"){
//           
//            bcpCurrentMarkerForm=jQuery("#bcpAddMarkerToNewForm");
//        }
//       bcpActiveTab.mainmenu=tabId;
//    }    


    
    if(typeof(elem.tab)=='function'){
        elem.tab("show");        
    }
    
//    switch(tabId){
//        
//        case "#bcpAddNewBackup":
//            currentMap = bcpMapsArr['mapPreviewToNewMap'];
//        break;
//        
//        case "#bcpAllBackups":
//            currentMap = bcpMapsArr["bcpEditMapsContainer"];
//        break;
//    
//        case "#bcpPluginSettings":
//            currentMap = bcpMapsArr["bcpMapForMarkerEdit"];
//        break;    
//    }

}     
function toggleBounce(marker,animType) {
    
    if(animType==0){
        return false;   
    }

    if (marker.getAnimation() != null) {
      marker.setAnimation(null);
    } else if(animType==2) {	
	      marker.setAnimation(null);
    }else{
	      marker.setAnimation(google.maps.Animation.BOUNCE);
	}
}
function bcp_func_get_args() {
  if (!arguments.callee.caller) {
      return "";
  }
  return Array.prototype.slice.call(arguments.callee.caller.arguments);
}
function outBcp(){
    console.log(bcp_func_get_args());
}
function bcpGetEditorContent(){
        
    return tinyMCE.activeEditor.getContent();
}
function bcpSetEditorContent(content,editorId){
        tinyMCE.activeEditor.setContent(content);
}
jQuery(document).ready(function(){
  jQuery('.nav.nav-tabs  a').click(function (e) {
    e.preventDefault();

    
    var href = jQuery(this).attr("href");
    if(href.replace("#","")=='bcpAddNewMap'){
            if(jQuery("#mapPreviewToNewMap").html().length<150){
                bcpDrawMap(bcpMapConstructParams);
              bcpCancelMapEdit();
            }
     }

     if(jQuery(this).parents('ul').hasClass("bcpMainTab")){
         bcpChangeTab(jQuery(this));         
     }else{
         bcpChangeTab(jQuery(this),true);
     }


   })
   
    jQuery(".bcpMapOptionsTab a").click(function(e){
            e.preventDefault();        
    })
    /*
     *  jQuery('.nav.nav-tabs li.bcpAllMaps  a').tab('show');
     */

    
     if(jQuery("#mapPreviewToNewMap").length>0 &&  jQuery("#mapPreviewToNewMap").html().length<150){
                bcpDrawMap(bcpMapConstructParams);                        
      }
    
    jQuery(".bcpNewMapOptsTab a").click(function(e){
        jQuery(".bcpNewMapOptsTab a").removeClass("btn-primary");
        jQuery(this).addClass("btn-primary");
    })
    

    
          try{
                def_tab_elem = jQuery(".bcpMainTab  li."+defaultOpenTab).find('a');
              
                if(bcpExistsTabs.indexOf(defaultOpenTab) == -1){
                         def_tab_elem = jQuery(".bcpMainTab li."+bcpExistsTabs[0]).find('a')
                } 
              bcpChangeTab(def_tab_elem);            
        }catch(e){
            
        }

    
    
    
    
})
function bcpGetLicenseBlock(){
       return '<a style="color: rgb(68, 68, 68); text-decoration: none; cursor: pointer;margin-right: 2px;margin-left: -21px;background-color: rgba(255, 255, 255, 0.37);" href="http://readyshoppingcart.com/product/google-maps-plugin/" target="_blank">' +'Google Maps WordPress Plugin'+'</a>';

}
function bcpAddLicenzeBlock(){

    var befElem = jQuery('.gmnoprint').find('.gm-style-cc');
    befElem.css('float', 'right');
    befElem.css('width', '400px');
    befElem.find('a').after(bcpGetLicenseBlock());
}