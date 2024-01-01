// Scroll Navbar

var prevScrollpos = window.pageYOffset;

window.onscroll = function() {

  var currentScrollpos = this.window.pageYOffset;

  if(prevScrollpos > currentScrollpos) {
      this.document.getElementById("navbar").style.top = "0";
  } else {
      this.document.getElementById("navbar").style.top = "-76px";
  }
  
  prevScrollpos = currentScrollpos;

}

// Table Filter

$(document).ready(function(){
  $("#boi-input").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#table tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
  
// Page Scroll

$(document).ready(function(){
  
  $(".page-scroll").on('click', function(event) {

    if (this.hash !== "") {
      
      event.preventDefault();

      var hash = this.hash;

      $('html, body').animate({
        scrollTop: $(hash).offset().top - 76
      }, 800, function(){
        
      });
    } 
  });
});

// Search Filter KS

$(document).ready(function(){
  $("#ks-input").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $('div[data-role="ks"]').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

// Search Filter Idea

$(document).ready(function(){
  $("#i-input").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $('a[data-role="i"]').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

// Search Filter User

$(document).ready(function(){
  $("#u-input").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $('li[data-role="u"]').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

// Progress Bar

$(document).ready(function(){

  $('.upload-video form').ajaxForm({
    beforeSend:function(){
      $('#success').empty();
    },
    uploadProgress:function(event, position, total, percentComplete)
    {
      $('.progress-bar').text('Uploading' + ' '  + '.'  + ' '  + '.'  + ' '  + '.'  + ' ' + percentComplete + '%');
      $('.progress-bar').css('width', percentComplete + '%');
    },
    success:function(data)
    {
      if(data.errors)
      {
        $('.progress-bar').text('0%');
        $('.progress-bar').css('width', '0%');
        $('#success').html('<small class="text-danger">'+data.errors+'</small>');
      }
      if(data.success)
      {
        $('.progress-bar').text('Please wait' + ' '  + '.'  + ' '  + '.'  + ' '  + '.');
        $('.progress-bar').css('width', '100%');
        $('#success').html('<small class="text-success">'+data.success+'</small>');
        window.location.href = "/knowledge-system";
      }
    }
  });

});

// Parallax

// window.onload = function(){

// }

// window.onscroll = function(){
//   var wScroll = this.scrollTop();

// }