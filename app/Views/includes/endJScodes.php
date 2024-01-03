<?php
$checkDir = base_url();
$user_id = session('id', null);
$page_name = $page;
?>
<script>// dont_write</script>
<script type="text/javascript">
//==================================================================
function delete_account(){
  if(confirm("Are you sure to delete your data permently?")){
    if(confirm("You will lose your data forever?")){
      if(confirm("You can't recover your data?")){
      }else{
        return false;
      }
    }else{
    return false;
    }
  }else{
    return false;
  }
}
function delete_transaction(table,cid){
  if(confirm("<?php echo langs('are_delete'); ?>")){
    $.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>Includes/delete_transaction',
        data:{'table':table,'cid':cid},
        beforeSend: function(){
            $('#tr_'+cid).hide();
        },
        success: function(done){
            if (done = 'yes') {
                $('#tr_'+cid).html('');
            }else{
                $('#tr_'+cid).show();
                alert('Action denied! You are not allowed to doing this action');
            }
        }
    });}
else{
    return false;
}
}

function fetchPosts_DB(){
	var fetchFrom = $("#fetchpost_db").val();
	var plimit = $("#GetLimitOfPosts").val();
	$('#LoadMorePostsBtn').hide();
	$.ajax({
		url: "Includes/fetch_posts_"+fetchFrom,
		type: "POST",
		data: {"plimit":plimit},
		beforeSend:function(){
			$('#LoadMorePostsBtn').hide();
			$('#LoadingPostsDiv').show();
		},
		success:function(data){
			$('#ErrorPosts').hide();
			if (data == 0) {
				$('#LoadMorePostsBtn').hide();
				$('#LoadingPostsDiv').hide();
				$('#NoMorePostsDiv').show();
			}else{
				$('#FetchingPostsDiv').append(data);
				$('#LoadMorePostsBtn').show();
				$('#LoadingPostsDiv').hide();
				document.getElementById("GetLimitOfPosts").value = Number(plimit)+10;
			}
		},
		error:function(){
			$('#LoadingPostsDiv').hide();
			$('#ErrorPosts').show();
			$('#LoadMorePostsBtn').show();
		},
	});
}
fetchPosts_DB();
document.getElementById('GetLimitOfPosts').value = 0;
function table_fetch(id,table,column,filter){
  $.ajax({
      type:'POST',
      data: {"table":table,"column":column,"filter":filter},
      url:'<?php echo base_url(); ?>includes/fetch_table',
      success: function(done){
        $(id).html(done);
      }
  });
}
function count_table(table_name,column,value,sid){
  $.ajax({
      type:'POST',
      data: {"table":table,"column":column,"value":value,"sid":sid},
      url:'<?php echo base_url(); ?>includes/count_table',
      success: function(done){
        $(id).html(done);
      }
  });
}
function blog_view(blog){
  $.ajax({
      type:'POST',
      data: {"blog":blog},
      url:'<?php echo base_url(); ?>includes/blog',
      success: function(done){
        $(id).html(done);
      }
  });
}
function browsing(table_name,column,id){
  $.ajax({
      type:'POST',
      data: {"table_name":table_name,"column":column,"id":id},
      url:'<?php echo base_url(); ?>includes/browsing',
      success: function(done){
        $(id).html(done);
      }
  });
}
function mode(){
    $.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>includes/mode',
        success: function(done){
              var $sidebar = $('body');
              var $html = $('html');
              if ($sidebar.hasClass('dark-skin')) {
                $sidebar.removeClass('dark-skin')
                $html.removeClass('dark-skin')

                $sidebar.addClass('light-skin')
                $html.addClass('light-skin')
              } else {
                $sidebar.removeClass('light-skin')
                $html.removeClass('light-skin')
                $sidebar.addClass('dark-skin')
                $html.addClass('dark-skin')
              }

        }
    });

}
function share(title,text,url) {
	if (navigator.share) { // Check if Web Share API is supported
		navigator.share({
			title: title,
			text: text,
			url: url
		})
			.then(() => console.log('Successful share'))
			.catch((error) => console.log('Error sharing', error));
	} else { // Fallback for browsers that do not support Web Share API
		const shareUrl = 'mailto:?subject='+text+'&body=I thought you might be interested in this website: '+url;
		window.location.href = shareUrl;
	}
}
function hide_text(id){
  var $text = $(id);
  if ($text.hasClass('regular')) {
    $text.removeClass('regular')
    $text.addClass('hash')
  } else {
    $text.removeClass('hash')
    $text.addClass('regular')
  }
}

</script>
<script>
	$(document).ready(function(){
		var i = 1;
		$("#postingToDB").on('submit',function(e){
				var plus = i++;
				$("#getingNP").prepend("<div id='FetchingNewPostsDiv"+plus+"' style='display:none;'></div>");
				e.preventDefault();
				$(this).ajaxSubmit({
					beforeSend:function(){
						$('.loadingPosting').show();
						$(".loadingPosting").html('<p class="loadingPostingP">0</p>');
						$(".loadingPostingP").css({'width' : '0%'});
					},
					uploadProgress:function(event,position,total,percentCompelete){
						$(".loadingPostingP").css({'width' : percentCompelete + '%'});
						$(".loadingPostingP").html(percentCompelete);
					},
					success:function(data){
						$('.empty').val('');
						$("#refresh").load(location.href + " #refresh");
						$(".loadingPosting").html(data);
						$(".loadingPosting").fadeOut(2000);
					}
				});

		});
	});
</script>
<script>
	//======class lazy==========
	$(document).ready(function() {
		const lazyImages = $('.lazy');

		$(lazyImages).each(function() {
			const img = $(this);
			const src = img.attr('src');

			img.attr('data-src', '<?php echo base_url(); ?>Asset/imgs/loading-waiting.gif');
			img.attr('src', src);
		});

		$(window).on('load scroll', function() {
			const threshold = $(window).scrollTop() + $(window).height();
			$(lazyImages).each(function() {
				const img = $(this);
				const offsetTop = img.offset().top;

				if (offsetTop < threshold) {
					img.attr('data-src', img.attr('src'));
					img.removeClass('lazy');
				}
			});
		});
	});
</script>
<script type="text/javascript">
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>
<script>
    function print_co(id){
      var print_div = document.getElementById("tr_"+id);
var print_area = window.open();
print_area.document.write(print_div.innerHTML);
print_area.document.close();
print_area.focus();
print_area.print();
print_area.close();
// This is the code print a particular div element
    }
</script>
<script>
$(function () {
  'use strict'

    $('[data-provide~="fullscreen"]').on('click', function () {
      screenfull.toggle($('#container')[0]);
    });

});
</script>
<script>
$(function() {

  function passwordCheck(password) {
    if (password.length >= 8)
      strength += 1;

    if (password.match(/(?=.*[0-9])/))
      strength += 1;

    if (password.match(/(?=.*[!,%,&,@,#,$,^,*,?,_,~,<,>,])/))
      strength += 1;

    if (password.match(/(?=.*[a-z])/))
      strength += 1;

    if (password.match(/(?=.*[A-Z])/))
      strength += 1;

    displayBar(strength);
  }

  function displayBar(strength) {
    switch (strength) {
      case 1:
        $("#password-strength span").css({
          "width": "20%",
          "background": "#de1616"
        });
        break;

      case 2:
        $("#password-strength span").css({
          "width": "40%",
          "background": "#de1616"
        });
        break;

      case 3:
        $("#password-strength span").css({
          "width": "60%",
          "background": "#de1616"
        });
        break;

      case 4:
        $("#password-strength span").css({
          "width": "80%",
          "background": "#FFA200"
        });
        break;

      case 5:
        $("#password-strength span").css({
          "width": "100%",
          "background": "#06bf06"
        });
        break;

      default:
        $("#password-strength span").css({
          "width": "0",
          "background": "#de1616"
        });
    }
  }

  $("[data-strength]").after("<div id=\"password-strength\" class=\"strength\"><span class=\"pst\"></span></div>")

  $("[data-strength]").focus(function() {
    $("#password-strength").css({
      "height": "7px"
    });
  }).blur(function() {
    $("#password-strength").css({
      "height": "0px"
    });
  });

  $("[data-strength]").keyup(function() {
    strength = 0;
    var password = $(this).val();
    passwordCheck(password);
  });

});
</script>
<script>
	function displayChart(name,type, labels, data) {
		// Get the canvas element
		const canvas = document.getElementById(name);

		// Create the chart object
		let chart;
		switch(type) {
			case 'bar':
				chart = new Chart(canvas, {
					type: 'bar',
					data: {
						labels: labels,
						datasets: [{
							label: name,
							data: data,
							backgroundColor: 'rgba(54, 162, 235, 0.2)',
							borderColor: 'rgba(54, 162, 235, 1)',
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
				});
				break;
			case 'line':
				chart = new Chart(canvas, {
					type: 'line',
					data: {
						labels: labels,
						datasets: [{
							label: name,
							data: data,
							borderColor: 'rgba(54, 162, 235, 1)',
							fill: false
						}]
					}
				});
				break;
			case 'pie':
				chart = new Chart(canvas, {
					type: 'pie',
					data: {
						labels: labels,
						datasets: [{
							label: name,
							data: data,
							backgroundColor: [
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(153, 102, 255, 0.2)',
								'rgba(255, 159, 64, 0.2)'
							],
							borderColor: [
								'rgba(255, 99, 132, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
							borderWidth: 1
						}]
					}
				});
				break;
			case 'doughnut':
				chart = new Chart(canvas, {
					type: 'doughnut',
					data: {
						labels: labels,
						datasets: [{
							label: name,
							data: data,
							backgroundColor: [
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(153, 102, 255, 0.2)',
								'rgba(255, 159, 64, 0.2)'
							],
							borderColor: [
								'rgba(255, 99, 132, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
							borderWidth: 1
						}]
					}
				});
				break;
			case 'scatter':
				chart = new Chart(canvas, {
					type: 'scatter',
					data: {
						datasets: [{
							label: name,
							data: data,
							backgroundColor: 'rgba(54, 162, 235, 1)',
							borderColor: 'rgba(54, 162, 235, 1)',
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							xAxes: [{
								type: 'linear',
								position: 'bottom'
							}]
						}
					}
				});
				break;
			case 'polar':
				chart = new Chart(canvas, {
					type: 'polarArea',
					data: {
						labels: labels,
						datasets: [{
							label: name,
							data: data,
							backgroundColor: [
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(153, 102, 255, 0.2)',
								'rgba(255, 159, 64, 0.2)'
							],
							borderColor: [
								'rgba(255, 99, 132, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
							borderWidth: 1
						}]
					}
				});
				break;
			default:
				console.error('Invalid chart type');
				break;
		}
	}

	// Example usage

</script>

<script type="text/javascript">
	function isNumberKey(className, evt) {
		var txt = document.querySelector('.' + className);
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode == 46) {
			//Check if the text already contains the . character
			if (txt.value.indexOf('.') === -1) {
				return true;
			} else {
				return false;
			}
		} else {
			if (charCode > 31 &&
				(charCode < 48 || charCode > 57))
				return false;
		}
		return true;
	}

	// Attach the function to input fields with a class of "num-input"
	var inputFields = document.querySelectorAll('.num-input');
	for (var i = 0; i < inputFields.length; i++) {
		inputFields[i].addEventListener('keypress', function(evt) {
			isNumberKey('num-input', evt);
		});
	}
</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=212322130"></script>

<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());
 gtag('config', '212322130');
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Corporation",
  "name": "<?php echo project_name(); ?>",
  "alternateName": "<?php echo author(); ?>",
  "url": "<?php echo base_url(); ?>",
  "logo": "<?php echo base_url(); ?>Asset/imgs/logo.ico",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+218913691247",
    "contactType": "customer service",
    "contactOption": ["TollFree","HearingImpairedSupported"],
    "areaServed": "LY",
    "availableLanguage": ["en","Arabic"]
  },
  "sameAs": "https://facebook.com/<?php echo author(); ?>"
}
</script>
<?php echo view("includes/jslinks"); ?>
<script>// /dont_write</script>
