$(document).ready(function(){
    var dtid = "<?= $dtid?>";
    var panel = $("#displayOptions-" + dtid)
    var exportpdf = panel.find('.tool-export-pdf');
    if(exportpdf.length == 1){
        exportpdf.click(function(e){
            e.preventDefault();
            exportData('pdf');
        });
    }

   function exportData(format){
       window.open(path + 'uihelper/export/laporan_member/' + format, '_blank');
   }
});