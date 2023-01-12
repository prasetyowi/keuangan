<!-- Menghubungkan dengan view template master -->
@extends('../layouts/layout')

<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->
@section('judul_halaman', 'Kategori Keuangan - Catatan Keuangan')

@section('konten')
<div class="main-content">
  <div class="main-content-inner">

    <div class="page-content">
      <div class="row">
        <div class="col-xs-12">
          <!-- PAGE CONTENT BEGINS -->
          <div class="invisible">
            <button data-target="#sidebar2" type="button" class="pull-left menu-toggler navbar-toggle">
              <span class="sr-only">Toggle sidebar</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="page-header">
            <h1>
              Laporan Keuangan Bulanan
            </h1>
          </div><!-- /.page-header -->

          <div class="row">
            <div class="col-xs-12 col-sm-12">

              <table id="table-laporan-keuangan" class="table table-bordered" style="width:20%;">
                <tbody>
                  <tr>
                    <th class="text-left">Pendapatan</th>
                    <th class="text-right text-primary">Rp. <span id="total_pendapatan">0</span></th>
                  </tr>
                  <tr>
                    <th class="text-left">Pengeluaran</th>
                    <th class="text-right text-danger">Rp. <span id="total_pengeluaran">0</span></th>
                  </tr>
                  <tr>
                    <th class="text-left">Total</th>
                    <th class="text-right text-success">Rp. <span id="grand_total">0</span></th>
                  </tr>
                </tbody>
              </table>

            </div>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <!-- PAGE CONTENT BEGINS -->
              <div class="row">
                <div class="col-sm-9">
                  <div class="space"></div>
                  <div id="calendar"></div>
                </div>
              </div>
              <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
          </div>

          <div class="hidden-sm hidden-xs">
            <button type="button" class="sidebar-collapse btn btn-white btn-primary" data-target="#sidebar">
              <i id="sidebar4-toggle-icon" class="ace-icon fa fa-angle-double-up ace-save-state" data-icon1="ace-icon fa fa-angle-double-up" data-icon2="ace-icon fa fa-angle-double-down"></i> Collapse/Expand Menu </button>
          </div>
          <!-- PAGE CONTENT ENDS -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.page-content -->
  </div>
</div><!-- /.main-content -->
@endsection

@section('script_function')
<script>
  // var date = new Date();
  // var d = date.getDate();
  // var m = date.getMonth();
  // var y = date.getFullYear();

  var dateObj = new Date();
  var m = dateObj.getUTCMonth() + 1; //months from 1-12
  var d = dateObj.getUTCDate();
  var y = dateObj.getUTCFullYear();

  function convert(str) {
    var date = new Date(str),
      mnth = ("0" + (date.getMonth() + 1)).slice(-2),
      day = ("0" + date.getDate()).slice(-2);
    return [date.getFullYear(), mnth, day].join("-");
  }

  var calendar = $('#calendar').fullCalendar({
    //isRTL: true,
    //firstDay: 1,// >> change first day of week

    buttonHtml: {
      prev: '<i class="ace-icon fa fa-chevron-left"></i>',
      next: '<i class="ace-icon fa fa-chevron-right"></i>'
    },

    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month'
    },
    events: function(start, end, timezone, callback) {
      jQuery.ajax({
        url: '/LaporanKeuangan/GetLaporanBulanan',
        type: 'GET',
        dataType: 'json',
        data: {
          start: convert(start),
          end: convert(end)
        },
        success: function(doc) {
          var events = [];
          $.each(doc, function(i, v) {
            events.push({
              id: v.szTransId,
              title: v.szDesc + " -  Rp. " + parseInt(v.decAmount),
              start: v.dtmTrans,
              className: v.szType == 'MASUK' ? 'label-success' : 'label-danger'
            });
          });
          // if (!!doc.result) {
          //   $.map(doc.result, function(r) {
          //     events.push({
          //       id: r.id,
          //       title: r.szDesc + " -  Rp. " + parseInt(r.decAmount),
          //       start: r.dtmTrans
          //     });
          //   });
          // }
          // console.log(events);
          callback(events);
        }
      });

      jQuery.ajax({
        url: '/LaporanKeuangan/GetTotalLaporanBulanan',
        type: 'GET',
        dataType: 'json',
        data: {
          tgl: convert("01 " + $(".fc-center")[0].textContent)
        },
        success: function(response) {

          $("#total_pendapatan").html('');
          $("#total_pengeluaran").html('');
          $("#grand_total").html('');

          $.each(response, function(i, v) {
            $("#total_pendapatan").append(parseInt(v.total_pendapatan));
            $("#total_pengeluaran").append(parseInt(v.total_pengeluaran));
            $("#grand_total").append(parseInt(v.total_pendapatan) - parseInt(v.total_pengeluaran));
          });

        }
      });
    },

    /**eventResize: function(event, delta, revertFunc) {

    	alert(event.title + " end is now " + event.end.format());

    	if (!confirm("is this okay?")) {
    		revertFunc();
    	}

    },*/

    editable: true,
    droppable: true, // this allows things to be dropped onto the calendar !!!
    drop: function(date) { // this function is called when something is dropped

      // retrieve the dropped element's stored Event Object
      var originalEventObject = $(this).data('eventObject');
      var $extraEventClass = $(this).attr('data-class');


      // we need to copy it, so that multiple events don't have a reference to the same object
      var copiedEventObject = $.extend({}, originalEventObject);

      // assign it the date that was reported
      copiedEventObject.start = date;
      copiedEventObject.allDay = false;
      if ($extraEventClass) copiedEventObject['className'] = [$extraEventClass];

      // render the event on the calendar
      // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
      $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

      // is the "remove after drop" checkbox checked?
      if ($('#drop-remove').is(':checked')) {
        // if so, remove the element from the "Draggable Events" list
        $(this).remove();
      }

    },
    selectable: true,
    selectHelper: true,
    select: function(start, end, allDay) {

      location.href = "/LaporanKeuangan/LaporanHarianByDate/" + convert(start);

      // bootbox.prompt("New Event Title:", function(title) {
      //   if (title !== null) {
      //     calendar.fullCalendar('renderEvent', {
      //         title: title,
      //         start: start,
      //         end: end,
      //         allDay: allDay,
      //         className: 'label-info'
      //       },
      //       true // make the event "stick"
      //     );
      //   }
      // });


      calendar.fullCalendar('unselect');
    },
    eventClick: function(calEvent, jsEvent, view) {

      // alert(calEvent._start);
      // console.log(calEvent._start);
      location.href = "/LaporanKeuangan/LaporanHarianByDate/" + convert(calEvent._start);

      //display a modal
      // var modal =
      //   '<div class="modal fade">\
      //   <div class="modal-dialog">\
      //    <div class="modal-content">\
      // 	 <div class="modal-body">\
      // 	   <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>\
      // 	   <form class="no-margin">\
      // 		  <label>Change event name &nbsp;</label>\
      // 		  <input class="middle" autocomplete="off" type="text" value="' + calEvent.title + '" />\
      // 		 <button type="submit" class="btn btn-sm btn-success"><i class="ace-icon fa fa-check"></i> Save</button>\
      // 	   </form>\
      // 	 </div>\
      // 	 <div class="modal-footer">\
      // 		<button type="button" class="btn btn-sm btn-danger" data-action="delete"><i class="ace-icon fa fa-trash-o"></i> Delete Event</button>\
      // 		<button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancel</button>\
      // 	 </div>\
      //   </div>\
      //  </div>\
      // </div>';


      // var modal = $(modal).appendTo('body');
      // modal.find('form').on('submit', function(ev) {
      //   ev.preventDefault();

      //   calEvent.title = $(this).find("input[type=text]").val();
      //   calendar.fullCalendar('updateEvent', calEvent);
      //   modal.modal("hide");
      // });
      // modal.find('button[data-action=delete]').on('click', function() {
      //   calendar.fullCalendar('removeEvents', function(ev) {
      //     return (ev._id == calEvent._id);
      //   })
      //   modal.modal("hide");
      // });

      // modal.modal('show').on('hidden', function() {
      //   modal.remove();
      // });


      //console.log(calEvent.id);
      //console.log(jsEvent);
      //console.log(view);

      // change the border color just for fun
      //$(this).css('border-color', 'red');

    }

  });
</script>

@endsection