let image_nameWhoweare = [];
let whoweareDropzoneInstance = null;
/* ================= who we are ================= */
function addWhoweareItem() {
  image_nameWhoweare = [];

  document.getElementById("whoweareModalTitle").textContent = "Add Who We Are";
  document.getElementById("whoweareeditType").value = "whoweare";
  document.getElementById("whoweareeditId").value = "";
  document.getElementById("whoweareeditTitle").value = "";
  // Clear Quill content
  if (window.whoweareEditor) {
    window.whoweareEditor.root.innerHTML = '';
  }
  document.getElementById("whoweareeditStatus").value = "active";
if (whoweareDropzoneInstance) {
    whoweareDropzoneInstance.removeAllFiles(true);
}
  hideAllFormFields();
  whoweareOpenModal();
}

function editWhoweareItem(id, title, content, imagePath, position = 1) {
  // image_nameWhoweare];
  console.log("Editing who we are with image:", position);

  document.getElementById("whoweareModalTitle").textContent = "Edit Who We Are";
  document.getElementById("whoweareeditType").value = "whoweare";
  document.getElementById("whoweareeditId").value = id;
  document.getElementById("whoweareeditTitle").value = title;
  // Set content in Quill
  if (window.whoweareEditor) {
    window.whoweareEditor.root.innerHTML = content;
  }
  document.getElementById("whoweareeditStatus").value = position;
  whoweareImageMock(imagePath);
  

  hideAllFormFields();
//   alert('om');
//   document.getElementById("whoweareFields").style.display = "block";
  whoweareOpenModal();
}

async function saveWhoweare() {
  // Clear previous errors
  document.getElementById("whoweareTitleError").style.display = "none";
  document.getElementById("whoweareContentError").style.display = "none";
  document.getElementById("whoweareImageError").style.display = "none";
  
  const id = document.getElementById("whoweareeditId").value;
  const title = document.getElementById("whoweareeditTitle").value.trim();
  const content = window.whoweareEditor ? window.whoweareEditor.root.innerHTML : '';
  const status = document.getElementById("whoweareeditStatus").value;
  
  let hasError = false;
  
  // Validation
  if (!title) {
    document.getElementById("whoweareTitleError").textContent = "Name is required";
    document.getElementById("whoweareTitleError").style.display = "block";
    document.getElementById("whoweareeditTitle").focus();
    hasError = true;
  } else if (title.length < 3) {
    document.getElementById("whoweareTitleError").textContent = "Name must be at least 3 characters long";
    document.getElementById("whoweareTitleError").style.display = "block";
    document.getElementById("whoweareeditTitle").focus();
    hasError = true;
  }
  
  if (!content) {
    document.getElementById("whoweareContentError").textContent = "Description is required";
    document.getElementById("whoweareContentError").style.display = "block";
    if (!hasError) document.getElementById("whoweareeditContent").focus();
    hasError = true;
  } else if (content.length < 10) {
    document.getElementById("whoweareContentError").textContent = "Description must be at least 10 characters long";
    document.getElementById("whoweareContentError").style.display = "block";
    if (!hasError) document.getElementById("whoweareeditContent").focus();
    hasError = true;
  }
  
  if (image_nameWhoweare.length === 0) {
    document.getElementById("whoweareImageError").textContent = "At least one image is required";
    document.getElementById("whoweareImageError").style.display = "block";
    hasError = true;
  }
  
  if (hasError) return;
  
  console.log("Saving who we are with images:", image_nameWhoweare);
  console.log("Title:", title);

  const payload = {
    name: title,
    content,
    description: content,
    image_path: image_nameWhoweare.join(","),
    status,
  };

  let action = "add_whoweare";
  if (id) {
    payload.id = id;
    action = "update_whoweare";
  }

  const res = await fetch(`../api/admin.php?action=${action}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload),
  });

  const data = await res.json();

  if (data.success) {
    whowearecloseModal();
   toastr.success(id ? "who we are updated" : "who we are added");
  } else {
    showNotification(data.message, "error");
  }
}

async function deleteWhoweareItem(id) {
  if (!confirm("Delete who we are?")) return;

  const res = await fetch(`../api/admin.php?action=delete_whoweare&id=${id}`, {
    method: "DELETE",
  });
  const data = await res.json();

  if (data.success) {
    showNotification("who we are deleted", "success");
    location.reload();
  }
}

/* ================= DROPZONE ================= */
Dropzone.options.whoweareDropzone = {
  maxFilesize: 5,
  acceptedFiles: "image/*",
  addRemoveLinks: true,

  init: function () {
    whoweareDropzoneInstance = this;
    this.on("success", (file, response) => {
      const res =
        typeof response === "string" ? JSON.parse(response) : response;

      if (res.status) {
        image_nameWhoweare.push(res.image_path);
        showNotification("Image uploaded", "success");
      } else {
        showNotification(res.message, "error");
      }
    });

    this.on("removedfile", () => {
      image_nameWhoweare = [];
    });
  },
};


function whoweareOpenModal() {
  // Clear any previous errors
  document.getElementById("whoweareTitleError").style.display = "none";
  document.getElementById("whoweareContentError").style.display = "none";
  document.getElementById("whoweareImageError").style.display = "none";
  
  document.getElementById("whoweareEditModal").style.display = "block";
  document.body.style.overflow = "hidden";
}




function whowearecloseModal() {
  document.getElementById("whoweareEditModal").style.display = "none";
  document.body.style.overflow = "auto";
}

function whoweareImageMock(imagePath) {
  if (!whoweareDropzoneInstance || !imagePath) return;

  whoweareDropzoneInstance.removeAllFiles(true);
  image_nameWhoweare = [];

  // ✅ comma separated images
  const images = imagePath.split(",").map((img) => img.trim());

  console.log("Prefilling ALL images:", images);

  images.forEach((img) => {
    const mockFile = {
      name: img.split("/").pop(),
      size: 123456,
      accepted: true,
    };

    whoweareDropzoneInstance.emit("addedfile", mockFile);
    whoweareDropzoneInstance.emit("thumbnail", mockFile, "../" + img);
    whoweareDropzoneInstance.emit("complete", mockFile);

    whoweareDropzoneInstance.files.push(mockFile);
    image_nameWhoweare.push(img); // ✅ keep in sync
  });
}

// Initialize form submission handler
document.addEventListener("DOMContentLoaded", function() {
  const whoweareForm = document.getElementById("whoweareEditForm");
  if (whoweareForm) {
    whoweareForm.addEventListener("submit", function(e) {
      e.preventDefault();
      saveWhoweare();
    });
  }

  // Handle edit button clicks
  document.addEventListener("click", function(e) {
    if (e.target.classList.contains("edit-whoweare-btn")) {
      const btn = e.target;
      const id = btn.getAttribute("data-id");
      const title = btn.getAttribute("data-title");
      const content = btn.getAttribute("data-content");
      const imagePath = btn.getAttribute("data-image");
      const status = btn.getAttribute("data-status");
      
      editWhoweareItem(id, title, content, imagePath, status);
    }
  });

  // Initialize Quill for Who We Are description
  if (document.getElementById('whoweareeditContent')) {
    window.whoweareEditor = new Quill('#whoweareeditContent', {
      theme: 'snow',
      modules: {
        toolbar: [
          [{ 'header': [1, 2, 3, false] }],
          ['bold', 'italic', 'underline'],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          ['link'],
          ['clean']
        ]
      },
      placeholder: 'Enter description...'
    });
  }
});
