	function draw(id, round, match, info, teams) {
        var canvas = document.getElementById(id);
        // alert(teams[info['host']]);
        if (canvas.getContext) {
          var ctx = canvas.getContext('2d');

          var host = teams[info['host']]+': '+info['host_score'];
          var guest = teams[info['guest']]+': '+info['guest_score'];
          var winner = teams[info['winner']];
          ctx.font = '12px serif';
          ctx.fillText(host, 13, 30);
          ctx.fillText(guest, 13, 70);
		      ctx.fillText(winner, 93, 50);

          ctx.strokeRect(10, 10, 60, 30);
          ctx.strokeRect(10, 50, 60, 30);
          ctx.strokeRect(90, 30, 60, 30);

          ctx.beginPath();
          ctx.moveTo(70, 25);
          ctx.lineTo(80, 25);
          ctx.lineTo(80, 40);
          ctx.lineTo(90, 40);

          ctx.moveTo(70, 65);
          ctx.lineTo(80, 65);
          ctx.lineTo(80, 50);
          ctx.lineTo(90, 50);
          ctx.stroke();

          ctx.closePath();


        }
      }