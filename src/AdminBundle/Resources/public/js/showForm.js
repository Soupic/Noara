$(".btnAddPost").click(
  function showForm() {
      $(".formHidden").slideDown();
  }
);

$(".btnDeletePost").click(
    function hideForm() {
        $(".formHidden").slideUp();
    }
);
