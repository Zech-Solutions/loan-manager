<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>
<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Events</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="no_of_events"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Organizers</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="no_of_organizers"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Judges</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="no_of_judges"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Participants</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="no_of_participants"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Calendar of Activities</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="calendar"></div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-5">
        <div class="card shadow mb-4 border-left-danger">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-danger" id="protest-title"></h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="timeline timeline-xs" id="protest" style="max-height: 423px;overflow: auto;">
                </div>   
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        getDashboardData();
        getEvents();
        getProtest();
    });

    function getDashboardData(){
        // ajax/get_events.php
        $.post("ajax/get_dashboard_data.php",{},function(data){
            var res = JSON.parse(data).data;
            $("#no_of_events").html(res.no_of_events);
            $("#no_of_organizers").html(res.no_of_organizers);
            $("#no_of_judges").html(res.no_of_judges);
            $("#no_of_participants").html(res.no_of_participants);
        });
    }

    function getEvents(){
        // ajax/get_events.php
        $.post("ajax/get_events.php",{},function(data){
            var res = JSON.parse(data);
            var events = [];

            for (let eventIndex = 0; eventIndex < res.data.length; eventIndex++) {
                const eventElem = res.data[eventIndex];
                events.push({
                    title: eventElem.event_name,
                    start: eventElem.event_start,
                    end: eventElem.event_start
                });
            }
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Set the initial view to month
                events: events
            });
            calendar.render();
        });
    }

    function getProtest(){
        $("#protest").html("");
        $.post("ajax/get_protests.php",{
            params:"WHERE protest_id > 0 ORDER BY date_added DESC"
        },function(data){
            var res = JSON.parse(data);

            $("#protest-title").html(`Protest (${res.data.length})`);

            for (let protestIndex = 0; protestIndex < res.data.length; protestIndex++) {
                const protest_row = res.data[protestIndex];
                $("#protest").append(`<div class="timeline-item">
                        <div class="timeline-item-marker">
                            <div class="timeline-item-marker-text">${protest_row.time_past}</div>
                        </div>
                        <div class="timeline-item-content">
                            <a class="fw-bold text-dark" href="index.php?page=event-details&event_id=${protest_row.event_id}">${protest_row.event_name}</a><br>
                            ${protest_row.protest}
                        </div>
                </div>`);
            }
        });
    }
</script>
<style>
.timeline .timeline-item {
  display: flex;
  align-items: flex-start;
}
.timeline .timeline-item .timeline-item-marker {
  display: inline-flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-bottom: 2rem;
}
.timeline .timeline-item .timeline-item-marker .timeline-item-marker-text {
  font-size: 0.875rem;
  width: 6rem;
  color: #a7aeb8;
  text-align: center;
  margin-bottom: 0.5rem;
  display: block;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
.timeline .timeline-item .timeline-item-marker .timeline-item-marker-indicator {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  height: 3rem;
  width: 3rem;
  background-color: #f2f6fc;
  border-radius: 100%;
}
.timeline .timeline-item .timeline-item-content {
  padding-top: 0;
  padding-bottom: 2rem;
  padding-left: 1rem;
  width: 100%;
}
.timeline .timeline-item:last-child .timeline-item-content {
  padding-bottom: 0 !important;
}

@media (min-width: 576px) {
  .timeline .timeline-item .timeline-item-marker {
    flex-direction: row;
    transform: translateX(1.625rem);
    margin-bottom: 0;
  }
  .timeline .timeline-item .timeline-item-marker .timeline-item-marker-text {
    margin-right: 0.5rem;
    margin-bottom: 0;
  }
  .timeline .timeline-item .timeline-item-content {
    padding-top: 0.75rem;
    padding-bottom: 3rem;
    padding-left: 3rem;
    border-left: solid 0.25rem #f2f6fc;
  }
  .timeline .timeline-item:last-child .timeline-item-content {
    border-left-color: transparent;
  }
}
.timeline.timeline-sm .timeline-item .timeline-item-marker {
  transform: translateX(0.875rem);
}
.timeline.timeline-sm .timeline-item .timeline-item-marker .timeline-item-marker-text {
  width: 3rem;
  font-size: 0.7rem;
}
.timeline.timeline-sm .timeline-item .timeline-item-marker .timeline-item-marker-indicator {
  height: 1.5rem;
  width: 1.5rem;
  font-size: 0.875rem;
}
.timeline.timeline-sm .timeline-item .timeline-item-marker .timeline-item-marker-indicator .feather {
  height: 0.75rem;
  width: 0.75rem;
}
.timeline.timeline-sm .timeline-item .timeline-item-content {
  font-size: 0.875rem;
  padding-top: 0.15rem;
  padding-bottom: 1rem;
  padding-left: 1.5rem;
}

.timeline.timeline-xs .timeline-item .timeline-item-marker {
  transform: translateX(0.5625rem);
}
.timeline.timeline-xs .timeline-item .timeline-item-marker .timeline-item-marker-text {
  width: 3rem;
  font-size: 0.7rem;
}
.timeline.timeline-xs .timeline-item .timeline-item-marker .timeline-item-marker-indicator {
  height: 0.875rem;
  width: 0.875rem;
  font-size: 0.875rem;
  border: 0.125rem solid #fff;
  margin-top: -0.125rem;
}
.timeline.timeline-xs .timeline-item .timeline-item-content {
  font-size: 0.875rem;
  padding-top: 0;
  padding-bottom: 1rem;
  padding-left: 1.5rem;
}


</style>
