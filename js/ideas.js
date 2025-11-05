/*
    Code for handling file uploads using the Trix document editor.
    Sean L
    23 November 2024
*/

function uploadFile(event) {

    function onUploadResponse() {
        if (this.readyState == 4 && this.status == 200) {
            newUploadUrl = this.responseText;
            fileInfo = {
                url: newUploadUrl,
                href: newUploadUrl + "?content-disposition=attachment"
            }
            console.log(fileInfo);
            event.attachment.setAttributes(fileInfo);
        }
    }

    let xhr = new XMLHttpRequest();
    let form = new FormData();
    form.append("file-to-upload", event.attachment.file);
    form.append("is-trix-upload", "true");
    xhr.onreadystatechange = onUploadResponse;
    xhr.open("POST", "http://cit.wvncc.edu/idea-repository/upload.php", true);
    xhr.send(form);
    console.log(event);
}

addEventListener("trix-attachment-add", uploadFile);