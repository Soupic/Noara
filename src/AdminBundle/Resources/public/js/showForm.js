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

// function showForm() {
//     this.style.display="block";
// }