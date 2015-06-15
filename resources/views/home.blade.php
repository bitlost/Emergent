@extends('layouts.default')


@section('content')
<style>
  td {
    height: 40px;
    width: 40px;
    border: 1px solid #000;
  }

  .live {
    background-color: orange;
  }
</style>
<script type='text/javascript'>
    $(document).ready(function () {
      var liveCells = [[1, 2], [2, 2], [3, 2]];

      function getNextGeneration() {

        var data = {
          'M': 5,
          'N': 5,
          'liveCells': liveCells
        };

        $.ajax({
          url: 'http://emergent.abitlost.com/api/nextgen',
          jsonp: 'callback',
          dataType: 'jsonp',
          data: data,
          success: function (response) {
            liveCells = response;
            drawGeneration(response);
          }
        });
      }


      $('#nextgen').click(function () {
        getNextGeneration();
      });

      drawGeneration(liveCells);

      function drawGeneration(newLiveCells) {

        //clear current board
        $('td').removeClass('live')

        $.each(newLiveCells, function (index, value) {
          var className = value[0] + '-' + value[1];
          $('.' + className).addClass('live');
        });
      }

    });
</script>

<table id="example">
  <?php for ($m = 0; $m < 5; $m++): ?>
      <tr>
        <?php for ($n = 0; $n < 5; $n++): ?>
            <td class="<?php echo sprintf('%s-%s', $m, $n); ?>"></td>
        <?php endfor; ?>
      </tr>
  <?php endfor; ?>

</table>
<button id="nextgen">Next Generation</button>
@endsection
