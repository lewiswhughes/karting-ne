<script>
  var ua = window.navigator.userAgent;
  var edge = ( ua.indexOf('Edge/') > -1 ) ? true : false;
  if( edge ){
    document.body.classList.add('edge-browser');
  }
  var ie = ( ua.indexOf('MSIE ') > -1 || ua.indexOf('Trident/') > -1 ) ? true : false ;
  if( ie ){
    document.body.classList.add('ie-browser');
    //remove add to cart forms
    var allForms = document.getElementsByTagName('form');
    console.log(allForms);
    for( var x = 0; x < allForms.length; x++ ){
      var form = allForms[x];
      if( form.classList.contains('cart') ){
        form.parentNode.removeChild(form);
      }
    }
    //get page url
    let pathname = window.location.pathname;
    //remove all children
    if( pathname.indexOf('booking') > -1 ){
      while (document.body.firstChild) {
        document.body.removeChild(document.body.firstChild);
      }
      //redirect
      window.location.href = '/update-browser/';
    }

  }
</script>
