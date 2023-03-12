<!-- clock code part II -->
<input type="hidden" id="scene_date" value="{{$sceneactor->scene->scene_date}}">
<input type="hidden" id="visit_date" value="{{$sceneactor->mc_visit_time()}}">
<script>

function get_relative_time(idvalue) 
  {
    $.ajax({
      type:'GET',
      url:"{{ route('scene.get_scene_ajax') }}",
      data:{idvalue:idvalue,what:'relative_time'},
      success:function(data){
          if($.isEmptyObject(data.error)){
            // alert(JSON.stringify(data, null, 4));
            if (data.scene_data.diff_sec != $('#relative_sec').val())
            {
              $('#relative_sec').val(data.scene_data.diff_sec);
            }
            if (data.scene_data.scene_step_minutes != $('#min_step').text())
            {
              $('#min_step').text(data.scene_data.scene_step_minutes);
            }
            }else{
              printErrorMsg(data.error);
            }
          }
      });
  }

function zegarek()
  {
    var zmienna = $('#relative_sec').val();

    var data = new Date(new Date().getTime()+(zmienna*1000-3600000)); //- 3600000: hand changing timezone

    @if ($view_action=='visit_in_progress')    
    var difff = 'nic';

    teraz = data;
    teraz = new Date(new Date().getTime()-3600000); //- 3600000: hand changing timezone
    dzien = new Date($('#visit_date').val());

    sekund = Math.abs(teraz-dzien)/1000;
    sekund = 60*10-Math.abs(teraz-dzien)/1000; //countdown
    if (sekund<0)
    {
      sekund=Math.abs(sekund)
      znak="-";
      $("#stopwatch").removeClass('bg-warning').addClass('bg-danger');
       
    }
    else if (sekund<=60)
    {
      $("#stopwatch").removeClass('bg-info').addClass('bg-warning');
      znak='';
    }
    else
    {
      znak='';
    }
    
    minut = parseInt(sekund/60);
    godzin = parseInt(minut/60);
    // dni = parseInt(godzin/24);
    
    sekund = parseInt((sekund-minut*60));
    // minut = parseInt((minut-godzin*60));
    // godzin = parseInt((godzin-dni*24));

    if (minut < 10) minut = "0" + minut;
    if (sekund < 10) sekund = "0" + sekund;

    difff = "<br><h1> " + znak + ' ' + minut + ':' + sekund + '</h1>';

    document.getElementById("stopwatch").innerHTML = difff;

    @endif

    var godzina = data.getHours();
    var minuta = data.getMinutes();
    var sekunda = data.getSeconds();
    var dzien = data.getDate();
    var dzienN = data.getDay();
    var miesiac = data.getMonth();
    var rok = data.getFullYear();
    
    if (minuta < 10) minuta = "0" + minuta;
    if (sekunda < 10) sekunda = "0" + sekunda;
    
    var dni = new Array("niedziela", "poniedziałek", "wtorek", "środa", "czwartek", "piątek", "sobota");
    var miesiace = new Array("stycznia", "lutego", "marca", "kwietnia", "maja", "czerwca", "lipca", "sierpnia", "września", "października", "listopada", "grudnia");
    
    var pokazDate = "<p>" + dni[dzienN] + ', ' + dzien + ' ' + miesiace[miesiac] + ' ' + rok + "</p><h1> " + godzina + ':' + minuta + ':' + sekunda + '</h1>';
    document.getElementById("zegar").innerHTML = pokazDate;

    get_relative_time({{$sceneactor->scene->id}});
    
    setTimeout(zegarek, 1000);            
  }

  window.onload = function() {
    zegarek();
  };


  function change_relative_time(idvalue) 
  {
    $('#change_relative_time').hide();
    $.ajax({
        type:'POST',
        url:"{{ route('scene.update_scene_ajax') }}",
        data:{
              what: 'relative_time',
              id: idvalue
            },
        success:function(data){
            if($.isEmptyObject(data.error)){
                // alert(JSON.stringify(data, null, 4));
                // alert(data.success);
                // location.reload();
            }else{
                printErrorMsg(data.error);
            }
        }
    });
    setTimeout(function() {
      $('#change_relative_time').show();
    }, 3000);       
  };
</script>  
<!-- end of clock code part II -->