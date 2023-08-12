function generateSlug(title, slugInput) {
    // convert the title to lowercase, replace spaces with hyphens, and remove invalid characters
    const slug = title
        .toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w-]/g, '');

    // set the slug value in the slugInput element
    slugInput.value = slug;
}
function sendData(data, url, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = () => {
        if (xhr.status === 200) {
            // console.log('Data successfully sent.');
            callback(null, xhr.responseText);
        } else {
            console.log('Request failed. Status:', xhr.status);
            callback(xhr.status);
        }
    };
    xhr.send(JSON.stringify(data));
}