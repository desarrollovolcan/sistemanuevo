<?php 

?>

    <!-- Core JS -->
    <script src="../../assest/js/jquery.min.js"></script>
    <script src="../../api/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables full bundle -->
    <script src="../../api/DataTables/datatables.min.js"></script>

    <!-- DataTables export deps -->
    <script src="../../api/DataTables/JSZip-2.5.0/jszip.min.js"></script>
    <script src="../../api/DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="../../api/DataTables/pdfmake-0.1.36/vfs_fonts.js"></script>

    <!-- Select2 -->
    <script src="../../api/select2/js/select2.full.min.js"></script>

    <!-- Configuración específica de tablas -->
    <script src="../../api/DataTables/data-table.js"></script>



    <script>
      // Menú desplegable tipo treeview (módulo / submódulo)
      document.addEventListener('DOMContentLoaded', function () {
        if (!window.jQuery) return;
        var $ = window.jQuery;

        // marcar li que tienen submenu
        $('.sidebar-menu li.treeview').each(function () {
          var $li = $(this);
          var $submenu = $li.children('.treeview-menu');
          if ($submenu.length) {
            // si algún hijo está activo, abrir por defecto
            if ($submenu.find('li.active').length) {
              $li.addClass('menu-open');
              $submenu.show();
            }
          }
        });

        // click en el enlace principal despliega / oculta
        $('.sidebar-menu').on('click', 'li.treeview > a', function (e) {
          var $li = $(this).parent();
          var $submenu = $li.children('.treeview-menu');
          if ($submenu.length) {
            e.preventDefault();
            $li.toggleClass('menu-open');
            $submenu.slideToggle(150);
          }
        });
      });
    </script>
