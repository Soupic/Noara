$(".btnAddPost").click(
  function showForm() {
      $(".form").slideDown();
  }
);

$(".btnDeletePost").click(
    function hideForm() {
        $(".form").slideUp();
    }
);
