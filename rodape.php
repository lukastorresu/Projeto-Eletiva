</main>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  document.getElementById("logoutButton").addEventListener("click", function(event) {
    event.preventDefault(); // Impede o redirecionamento imediato

    Swal.fire({
      title: 'Você tem certeza?',
      text: "Deseja sair do sistema?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim, sair',
      cancelButtonText: 'Cancelar',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // Se o usuário confirmar, redireciona para a página de logout
        window.location.href = "sair.php";
      }
    });
  });
</script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script>
  var table = new DataTable('#tabela', {
    language: {
      url: 'js/pt-BR.json',
    },
  });
</script>
</body>

</html>