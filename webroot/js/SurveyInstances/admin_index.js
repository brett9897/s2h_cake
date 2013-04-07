(function() {
  var columnLabels, columnTableOptions, columns, create_custom_report;

  columnTableOptions = [
    {
      "bSortable": true,
      "bSearchable": true
    }, {
      "bSortable": true,
      "bSearchable": true
    }, {
      "bSortable": false,
      "bSearchable": false
    }, {
      "bSortable": false,
      "bSearchable": false
    }, {
      "bSortable": true,
      "bSearchable": false
    }
  ];

  columns = ['Client.first_name', 'Client.last_name', 'Client.dob', 'Client.ssn', 'SurveyInstace.vi_score'];

  columnLabels = ['First Name', 'Last Name', 'DOB', 'SSN', 'VI Score'];

  $(function() {
    return $(document).ready(function() {
      var oTable;

      oTable = $("#clientsResults").dataTable({
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "" + global.base_url + "/survey_instances/dataTables.json",
        "fnServerParams": function(aoData) {
          aoData.push({
            "name": "survey_id",
            "value": location.href.substring(location.href.lastIndexOf("/") + 1)
          });
          return aoData.push({
            "name": "aColumns",
            "value": columns
          });
        },
        "aoColumns": columnTableOptions,
        "aaSorting": [[1, 'asc']]
      }).fnSetFilteringDelay(1000);
      $('#clientsResults').on('click', 'tbody tr', function(event) {
        var id;

        id = $(this).attr('id');
        return location.href = "" + global.base_url + "/clients/view/" + (id.substr(id.indexOf('_') + 1));
      });
      $('#custom-report-select').dialog({
        autoOpen: false,
        modal: true,
        show: {
          effect: 'slide',
          direction: 'left'
        },
        hide: {
          effect: 'slide',
          direction: 'right'
        },
        buttons: {
          Ok: function() {
            $(this).dialog('close');
            return $('#custom-report-options').dialog('open');
          }
        }
      });
      return $('#custom-report-options').dialog({
        autoOpen: false,
        modal: true,
        show: {
          effect: 'slide',
          direction: 'left'
        },
        hide: {
          effect: 'slide',
          direction: 'right'
        }
      });
    });
  });

  create_custom_report = function() {
    return $('#custom-report-select').dialog('open');
  };

  window.create_custom_report = create_custom_report;

}).call(this);
