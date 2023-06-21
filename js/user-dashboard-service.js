var UserDashboardService = {
  init: function() {
    UserDashboardService.last();
    UserDashboardService.get_id();
    UserDashboardService.list_last_memberships();
  },

  last: function() {
    $.ajax({
      url: '../rest/last_active/' + parse_jwt(localStorage.getItem('token')).id,
      type: "GET",
      beforeSend: function(xhr) {
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function(data) {
        $("#valid").html(`<div class="text-success text-center mt-2" id="valid"><h1>${data.end_date}</h1></div>`);
        $("#membership_name").html(`<div class="text-success text-center mt-2" id="valid"><h1>${data.description}</h1></div>`);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
      }
    });
  },

  get_id: function() {
    $("#end").html(`<div class="text-info text-center mt-2" id="end"><h1>${parse_jwt(localStorage.getItem('token')).id}</h1></div>`);
  },

  list_last_memberships: function() {
    $.ajax({
      url: '../rest/last_memberships/' + parse_jwt(localStorage.getItem('token')).id,
      type: "GET",
      beforeSend: function(xhr) {
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function(data) {
        var html = "";
        for (let i = 0; i < data.length; i++) {
          html += `<tr>
                      <td>${data[i].id}</td>
                      <td>${data[i].description}</td>
                      <td>${data[i].start_date}</td>
                      <td>${data[i].end_date}</td>
                    </tr>`;
        }
        $("#user-dashboard-membership-table-list tbody").html(html);
      }
    });
  },
};
