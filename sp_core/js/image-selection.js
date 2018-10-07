
/**
 * On page load, display or hide the preview image element.
 *
 */
window.onload = function()
{
    var pImg = document.getElementById("preview-image");
    var pSrc = pImg.getAttribute("src");
    var hVar = document.getElementById("remove-image");

    if (pSrc == "")
    {
        pImg.style.display = "none";
    }
    else
    {
        hVar.style.display = "unset";
    }
}

/**
 * 
 * @param input
 */
function readURL(input) 
{
    if (input.files && input.files[0]) 
    {
        var reader = new FileReader();

        reader.onload = function (e) 
        {
            document.getElementById("preview-image").src = e.target.result;
            document.getElementById("thumbnail").value = e.target.result;
        };
        
        reader.readAsDataURL(input.files[0]);
        document.getElementById("preview-image").style.display = "block";
        document.getElementById("remove-image").style.display = "block";
    }
}

/**
 * Remove the source/value related to thumbnail (post preview image) data.
 *
 * @param imageElementName
 * @param buttonElement
 */
function removeURL(imageElementName, buttonElement)
{
    var imgElement = document.getElementById(imageElementName);
    imgElement.src = "";
    document.getElementById("fileToUpload").value = "";
    document.getElementById("thumbnail").value = "";
    buttonElement.style.display = "none";
    imgElement.style.display = "none";
}