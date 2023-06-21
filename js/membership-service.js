var MembershipService = {
  init: function () {
    $("#addMembershipForm").validate({
      submitHandler: function (form) {
        var entity = Object.fromEntries(new FormData(form).entries());

        // add method
        MembershipService.add(entity);
      },
    });

    $("#updateMembershipForm").validate({
      submitHandler: function (form) {
        var entity = Object.fromEntries(new FormData(form).entries());
        console.log(entity);
        var id = entity.id;
        delete entity.id;
        console.log("Before update");
        // update method
        MembershipService.update(id, entity);
      },
    });

    MembershipService.list();
  },

  list: function () {
    $.ajax({
      url: "rest/usermembership",
      type: "GET",
      beforeSend: function (xhr) {
        xhr.setRequestHeader("Authorization", localStorage.getItem("token"));
      },
      success: function (data) {
       // $("#membership-table-full").html("");
        var html = "";
        for (let i = 0; i < data.length; i++) {
          html +=
            `
             <tr>
                                      <td>` +
            data[i].id +
            ` </td>
                                      <td>` +
            data[i].name +
            ` </td>
                                      <td>` +
            data[i].description +
            ` </td>
                                      <td>` +
            data[i].start_date +
            `</td>
                                      <td>` +
            data[i].end_date +
            `</td>
                                      <td>
                                        <button type="button" class="btn btn-success membership-button" onclick="MembershipService.get(` +
            data[i].id +
            `) "><i class="fa fa-edit"></i></button>
                                      <button type="button" class="btn btn-danger membership-button" onclick="MembershipService.delete(` +
            data[i].id +
            `)"><i class="fa fa-trash"></i></button>
                                      </td>
                                    </tr>`;
        }
        //  let oldHtml = $("#membership-table-full-list").html();
        //  $("#membership-table-full-list").html(oldHtml+html);
        $("#membership-table-full tbody").html(html);
        $("#membership-table-full").DataTable();
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
      },
    });
  },
  add: function (user) {
    $.ajax({
      url: "rest/usermembership",
      type: "POST",
      data: JSON.stringify(user),
      contentType: "application/json",
      dataType: "json",
      beforeSend: function (xhr) {
        xhr.setRequestHeader("Authorization", localStorage.getItem("token"));
      },
      success: function (result) {
        //$("#membership-table-full").html(
          //'<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>'
        //);
        //$("#membership-table-full").DataTable();
        MembershipService.list(); // perf optimization
        $("#addMembershipModal").modal("hide");
        $(".modal-backdrop").remove();
        toastr.success("Membership added!");
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
      },
    });
  },
  delete: function (id) {
    //$('.user-button').attr('disabled', true);
    $.ajax({
      url: "rest/usermembership/" + id,
      type: "DELETE",
      beforeSend: function (xhr) {
        xhr.setRequestHeader("Authorization", localStorage.getItem("token"));
      },
      success: function (result) {
        $("#membership-table-full tbody").html(
          '<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>'
        );
        $("#membership-table-full").DataTable();
        MembershipService.list();
        location.reload();
        toastr.success("Membership deleted!");
        
      },
    });
  },
  get: function (id) {
    $(".employe-button").attr("disabled", true);
    $.ajax({
      url: "rest/usermembership/" + id,
      type: "GET",
      beforeSend: function (xhr) {
        xhr.setRequestHeader("Authorization", localStorage.getItem("token"));
      },
      success: function (data) {
        $('#updateMembershipForm input[name="id"]').val(data.id);
        $('#updateMembershipForm  input[name="name"]').val(data.name);
        $('#updateMembershipForm  input[name="description"]').val(
          data.description
        );
        $('#updateMembershipForm  input[name="start_date"]').val(
          data.start_date
        );
        $('#updateMembershipForm  input[name="end_date"]').val(data.end_date);

        $(".membership-button").attr("disabled", false);
        $("#updateMembershipModal").modal("show");
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
        $(".employe-button").attr("disabled", false);
      },
    });
  },

  update: function (id, entity) {
    $.ajax({
      url: "rest/usermembership/" + id,
      type: "PUT",
      beforeSend: function (xhr) {
        xhr.setRequestHeader("Authorization", localStorage.getItem("token"));
      },
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",
      success: function (result) {
        $("#membership-table-full-list").html(
          '<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>'
        );
        MembershipService.list(); // perf optimization
        $("#updateMembershipModal").modal("hide");
        toastr.success("Membership updated!");
      },
    });
  },
};
