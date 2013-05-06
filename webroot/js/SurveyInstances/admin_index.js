(function() {
  var build_header, columnLabels, columnTableOptions, columns, create_custom_report, defaults, draw_table, export_to_csv, oTable, use_default_report;

  defaults = [];

  defaults['columns'] = ['Client.first_name', 'Client.last_name', 'Client.dob', 'Client.ssn', 'SurveyInstance.vi_score'];

  defaults['columnLabels'] = ['First Name', 'Last Name', 'DOB', 'SSN', 'VI Score'];

  defaults['columnTableOptions'] = [
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

  columns = defaults['columns'].slice(0);

  columnTableOptions = defaults['columnTableOptions'].slice(0);

  columnLabels = defaults['columnLabels'].slice(0);

  oTable = null;

  draw_table = function() {
    return $("#clientsResults").dataTable({
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
  };

  $(function() {
    return $(document).ready(function() {
      var get_custom_data, setFields;

      oTable = draw_table();
      $('#clientsResults').on('click', 'tbody tr', function(event) {
        var id;

        id = $(this).attr('id');
        return location.href = "" + global.base_url + "/clients/view/" + (id.substr(id.indexOf('_') + 1));
      });
      $('#custom-report-select').dialog({
        autoOpen: false,
        modal: true,
        width: 780,
        height: 500,
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
            if ($('#selectable > li.ui-selected').length !== 0) {
              setFields();
              $(this).dialog('close');
              return $('#custom-report-options').dialog('open');
            }
          }
        }
      });
      $('#custom-report-options').dialog({
        autoOpen: false,
        modal: true,
        width: 500,
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
            get_custom_data();
            oTable.fnDestroy();
            build_header();
            oTable = draw_table();
            return $(this).dialog('close');
          }
        }
      });
      $('#selectable').selectable();
      setFields = function() {
        var column, id, options_body, options_html, _i, _len, _ref, _results;

        options_html = "<td><select class='sortable'><option>true</option><option>false</option></td><td><select class='searchable'><option>true</option><option>false</option></td>";
        options_body = $("#custom-report-options > table > tbody");
        options_body.html('');
        _ref = $('#selectable > li.ui-selected');
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          column = _ref[_i];
          id = $(column).find('.element').attr('id');
          _results.push(options_body.append("<tr><td id='" + id + "' class='col_val'>" + ($(column).text().trim()) + "</td>" + options_html + "</tr>"));
        }
        return _results;
      };
      get_custom_data = function() {
        var row, _i, _len, _ref, _results;

        columns.length = 0;
        columnTableOptions.length = 0;
        columnLabels.length = 0;
        _ref = $('#custom-report-options > table > tbody > tr');
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          row = _ref[_i];
          columns.push($(row).find('.col_val').attr('id').trim());
          columnTableOptions.push({
            'bSortable': $(row).find('.sortable').val().toLowerCase() === 'true',
            'bSearchable': $(row).find('.searchable').val().toLowerCase() === 'true'
          });
          _results.push(columnLabels.push($(row).find('.col_val').text().trim()));
        }
        return _results;
      };
    });
  });

  build_header = function() {
    var header;

    header = $('#clientsResults');
    header.html("<thead><tr><th>" + (columnLabels.join('</th><th>')) + "</th></tr></thead>");
  };

  create_custom_report = function() {
    return $('#custom-report-select').dialog('open');
  };

  use_default_report = function() {
    columns = defaults['columns'].slice(0);
    columnTableOptions = defaults['columnTableOptions'].slice(0);
    columnLabels = defaults['columnLabels'].slice(0);
    oTable.fnDestroy();
    build_header();
    return oTable = draw_table();
  };

  export_to_csv = function() {
    var survey_id;

    survey_id = location.href.substring(location.href.lastIndexOf("/") + 1);
    location.href = "" + global.base_url + "/survey_instances/custom_xls?survey_id=" + survey_id + "&aColumns=" + columns;
  };

  window.create_custom_report = create_custom_report;

  window.use_default_report = use_default_report;

  window.export_to_csv = export_to_csv;

}).call(this);
