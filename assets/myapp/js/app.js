var frm = document.getElementById('formulario');

document.addEventListener('DOMContentLoaded', function(){
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
    locale: 'es',
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        dateClick: function(info){
        $.ajax({
            url:myBase_url+"index.php/Calendario/GetDataAlumnoByEmailPadre",
            type:'POST',
            async: true,
            success:function(datos){        
            var obj = JSON.parse(datos);
            var alumno = obj[0].nombre_nino + ' ' + obj[0].apaterno_nino + ' ' + obj[0].amaterno_nino;
            var nivel = obj[0].nivel
    
            document.getElementById('start').value = info.dateStr;
            document.getElementById('titulo').textContent = "Agendar Clase";
            document.getElementById('alumno').value = alumno;
            document.getElementById('nivel').value = nivel;
            $("#myModal").modal();
            $('#alumno').attr('disabled',true);
            $('#nivel').attr('disabled',true);
            }
        });
        },
    });
    calendar.render();
    document.getElementById('formulario').addEventListener('submit', function(e) {
    //e.preventDefault();
    });
});