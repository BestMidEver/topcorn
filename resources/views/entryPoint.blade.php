<!DOCTYPE html>
<html>
<body>

<h1>My First Headings</h1>
<p>My first paragraph.</p>

<div id="app">
@{{ message }}
</div>

</body>
<script src="https://npmcdn.com/vue/dist/vues.js"></script>
<script src="https://npmcdn.com/vue-router/dist/vue-router.js"></script>
<script src="/vue/app.js?v={{config('constants.version')}}"></script>
</html>