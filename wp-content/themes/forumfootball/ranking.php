<style type="text/css">
#ranking {
	width: 300px;
	height: 300px;
}
</style>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js">
</script>
<script type="text/javascript">
var myIframe = document.getElementById('ranking');
myIframe.onload = function () {
    myIframe.contentWindow.scrollTo(0,100);
}
</script>


<iframe id="ranking" scrolling="yes" src="http:\/\/www.goal.com/en/">
</iframe>
