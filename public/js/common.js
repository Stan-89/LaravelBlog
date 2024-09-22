
/*
  Activate a menu
  1 - Dashboard
  2 - Posts
  3 - Categories
  4 - Contact Messages
*/

function activateMenu(theInt)
{
  $('.top-nav nav ul').children().eq((theInt -1)).addClass('active');
}

function activateListenersDelete()
{
  $('.deleteLink').on('click', function(e){
    if(!confirm("Are you sure that you want to delete this?"))
    {
          e.preventDefault();
    }
  });
}
