function AjaxObject( meth, url){
         var x = new XMLHttpRequest();
         x.open( meth, url, true);
         x.setRequestHeader("content-type","application/x-www-form-urlencoded");
              return x;
        }
    
     function ajaxReturn(x){
     if(x.readyState == 4 && x.status == 200){
                return true;
            }
         
       }
        
function _(x){
   return document.getElementById(x);
     }//end tag handler
     
     function emptystatus(x){
    _(x).innerHTML=" ";
    
}//empty status 