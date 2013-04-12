(function() {
  var columnTableOptions, columns, create_custom_report, defaults;

  defaults = [];

  defaults['columns'] = ['Client.first_name', 'Client.last_name', 'Client.dob', 'Client.ssn', 'SurveyInstace.vi_score'];

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

  columns = defaults['columns'];

  columnTableOptions = defaults['columnTableOptions'];

  $(function() {
    return $(document).ready(function() {
      var draw_table, header_string, oTable, setFields;

      header_string = '';
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
      oTable = draw_table();
      $('#clientsResults').on('click', 'tbody tr', function(event) {
        var id;

        id = $(this).attr('id');
        return location.href = "" + global.base_url + "/clients/view/" + (id.substr(id.indexOf('_') + 1));
      });
      $('#custom-report-select').dialog({
        autoOpen: false,
        modal: true,
        width: 815,
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
            setFields();
            $(this).dialog('close');
            return $('#custom-report-options').dialog('open');
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
        }
      });
      $('#selectable').selectable();
      return setFields = function() {
        var column, options_body, options_html, _i, _len, _ref, _results;

        options_html = "<td class='sortable'><select><option>true</option><option>false</option></td><td class='sortable'><select><option>true</option><option>false</option></td>";
        header_string = '';
        options_body = $("#custom-report-options > table > tbody");
        options_body.html('');
        _ref = $('#selectable > li.ui-selected');
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          column = _ref[_i];
          header_string += "<th>" + ($(column).html()) + "</th>";
          _results.push(options_body.append("<tr><td>" + ($(column).html()) + "</td>" + options_html + "</tr>"));
        }
        return _results;
      };
    });
  });

  create_custom_report = function() {
    return $('#custom-report-select').dialog('open');
  };

  window.create_custom_report = create_custom_report;

}).call(this);
