$(function(){
    $('#convert').on('click', function(){
        TableToExcel.convert(document.getElementById("dtHorizontalExample"), {
            name: "databtc.xlsx",
            sheet: {
              name: "Sheet 1"
            }
          });
    })
})