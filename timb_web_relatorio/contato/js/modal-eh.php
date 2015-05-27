<script type="text/javascript">

var modal = {};
modal.hide = function() {
  $('#overlay').fadeOut();
  $('.dialog').fadeOut();
};

$(document).ready(function() {
  // Open appropriate dialog when clicking on anything with class "dialog-open"
  $('.dialog-open').click(function() {
    var x = this.id;
    modal.id = '#dialog-'+ x;
    alert(modal.id);
    $('#overlay').fadeIn();
    $(modal.id).fadeIn();
  });
  // Close dialog when clicking on the "x-dialog"
  $('.x-dialog').click(function() {
    modal.hide();
  });
  // Require the user to click OK if the dialog is classed as "modal"
  $('#overlay').click(function() {
    if ($(modal.id).hasClass('modal')) {
      // Do nothing
    } else {
      modal.hide();
    }
  });
  // Prevent dialog closure when clicking the body of the dialog (overrides closing on clicking overlay)
  $('.dialog').click(function() {
    event.stopPropagation();
  });
});
</script>