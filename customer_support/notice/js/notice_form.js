// <!-- =================================================================
// + [DESC] notice_form.js 총괄
// + [DATE] 2019-05-26
// + [NAME] 이우주
// ================================================================= -->



$(document).ready(function() {
   $('#summernote').summernote({
           height: 800,
           minHeight: null,
           maxHeight: null,
           focus: true,
           callbacks: {
            onImageUpload : function(files, editor, welEditable){
              sendFile(files[0], editor, welEditable);
            }
           }
   });
function sendFile(file,editor,welEditable){
  data = new FormData();
  data.append("file", file);
  $.ajax({
      data: data,
      type: "POST",
      url: "http://localhost/santteut/customer_support/notice/notice_saveimage.php",
      cache: false,
      contentType: false,
      processData: false,
      success: function(url) {
        var html = '<img src="'+url+'">';
        $('#summernote').summernote('pasteHTML', html);
        $('#summernote').summernote('insertImage', url, filename);
      }
  });
}

});
