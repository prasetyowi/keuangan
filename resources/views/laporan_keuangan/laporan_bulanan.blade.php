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
  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();


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
      right: 'month,agendaWeek,agendaDay'
    },
    events: [
      <?php foreach ($data['laporan_bulanan'] as $value) : ?>
      <?php endforeach ?>

      {
        title: 'All Day Event',
        start: new Date(y, m, 1),
        className: 'label-important'
      },
      {
        title: 'Long Event',
        start: moment().subtract(5, 'days').format('YYYY-MM-DD'),
        end: moment().subtract(1, 'days').format('YYYY-MM-DD'),
        className: 'label-success'
      },
      {
        title: 'Some Event',
        start: new Date(y, m, d - 3, 16, 0),
        allDay: false,
        className: 'label-info'
      }
    ],

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

      bootbox.prompt("New Event Title:", function(title) {
        if (title !== null) {
          calendar.fullCalendar('renderEvent', {
              title: title,
              start: start,
              end: end,
              allDay: allDay,
              className: 'label-info'
            },
            true // make the event "stick"
          );
        }
      });


      calendar.fullCalendar('unselect');
    },
    eventClick: function(calEvent, jsEvent, view) {

      //display a modal
      var modal =
        '<div class="modal fade">\
			  <div class="modal-dialog">\
			   <div class="modal-content">\
				 <div class="modal-body">\
				   <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>\
				   <form class="no-margin">\
					  <label>Change event name &nbsp;</label>\
					  <input class="middle" autocomplete="off" type="text" value="' + calEvent.title + '" />\
					 <button type="submit" class="btn btn-sm btn-success"><i class="ace-icon fa fa-check"></i> Save</button>\
				   </form>\
				 </div>\
				 <div class="modal-footer">\
					<button type="button" class="btn btn-sm btn-danger" data-action="delete"><i class="ace-icon fa fa-trash-o"></i> Delete Event</button>\
					<button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancel</button>\
				 </div>\
			  </div>\
			 </div>\
			</div>';


      var modal = $(modal).appendTo('body');
      modal.find('form').on('submit', function(ev) {
        ev.preventDefault();

        calEvent.title = $(this).find("input[type=text]").val();
        calendar.fullCalendar('updateEvent', calEvent);
        modal.modal("hide");
      });
      modal.find('button[data-action=delete]').on('click', function() {
        calendar.fullCalendar('removeEvents', function(ev) {
          return (ev._id == calEvent._id);
        })
        modal.modal("hide");
      });

      modal.modal('show').on('hidden', function() {
        modal.remove();
      });


      //console.log(calEvent.id);
      //console.log(jsEvent);
      //console.log(view);

      // change the border color just for fun
      //$(this).css('border-color', 'red');

    }

  });
</script>

@endsection