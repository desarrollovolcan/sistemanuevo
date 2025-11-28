<?php 

?>

    <!-- Core JS -->
    <script src="../../assest/js/jquery.min.js"></script>
    <script src="../../api/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables full bundle -->
    <script src="../../api/DataTables/datatables.min.js"></script>
    <script src="../../api/DataTables/Buttons-2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="../../api/DataTables/Buttons-2.1.1/js/buttons.bootstrap4.min.js"></script>
    <script src="../../api/DataTables/Buttons-2.1.1/js/buttons.html5.min.js"></script>
    <script src="../../api/DataTables/SearchBuilder-1.3.0/js/dataTables.searchBuilder.min.js"></script>
    <script src="../../api/DataTables/DateTime-1.1.1/js/dataTables.dateTime.min.js"></script>

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

        
        // click en el enlace principal despliega / oculta solo su módulo
        $('.sidebar-menu').on('click', 'li.treeview > a', function (e) {
          var $li = $(this).parent();
          var $submenu = $li.children('.treeview-menu');
          if (!$submenu.length) {
            return; // nada que desplegar
          }
          e.preventDefault();

          var isOpen = $li.hasClass('menu-open');

          // cerrar hermanos abiertos en el mismo nivel
          $li.siblings('.treeview.menu-open').each(function () {
            $(this).removeClass('menu-open')
                   .children('.treeview-menu:visible').slideUp(150);
          });

          if (isOpen) {
            $li.removeClass('menu-open');
            $submenu.slideUp(150);
          } else {
            $li.addClass('menu-open');
            $submenu.slideDown(150);
          }
        });

      });
    </script>
