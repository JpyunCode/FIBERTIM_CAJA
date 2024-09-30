<style>
  .logo {
    margin: auto;
    font-size: 20px;
    background: white;
    padding: 7px 11px;
    border-radius: 50% 50%;
    color: #000000b3;
  }
</style>
<div id="page">
</div>


<div id="loading"></div>
<nav class="navbar navbar-light fixed-top">
  <div class="container-fluid mt-2 mb-2">
    <div class="col-lg-12">
      <div class="float-left">
        <div class=" dropdown mr-4">
          <h3 class="dropdown-item"> CAJA FIBERTIM </h3>
        </div>
      </div>
      <div class="float-right">
        <div class=" dropdown mr-4">
          <a class="dropdown-item" href="#" onclick="myFunction()"><i class="fa fa-power-off"></i> Logout</a>
        </div>
      </div>
    </div>
  </div>

</nav>


<script>
  $('#manage_my_account').click(function() {
    uni_modal("Manage Account", "manage_user.php?id=<?php echo $_SESSION['login_IdUsuario'] ?>&mtype=own")
  })
</script>
<script>
  function myFunction() {
    let text;
    if (confirm("Desea salir del sistema?") == true) {
      $.ajax({
        url: 'assets/php/functions/ajax.php?action=logout',
        error: err => {
            console.log()
            alert("Ocurrió un error")
        },
        success: function() {
          setTimeout(function() {
						location.reload()
					}, 500)
        }
        })
    }
  }
</script>