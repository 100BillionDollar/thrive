
/* ================= BANNERS ================= */
function addBanner() {
  image_name = [];

  document.getElementById("modalTitle").textContent = "Add Banner";
  document.getElementById("editType").value = "banner";
  document.getElementById("editId").value = "";
  document.getElementById("bannereditTitle").value = "";
  document.getElementById("bannereditContent").value = "";
  document.getElementById("bannereditPosition").value = "1";
if (bannerDropzoneInstance) {
    bannerDropzoneInstance.removeAllFiles(true);
}
  hideAllFormFields();
  document.getElementById("bannerFields").style.display = "block";
  openModal();
}

function editBanner(id, title, content, imagePath, position = 1) {
  // image_name];
  console.log("Editing banner with image:", position);

  document.getElementById("modalTitle").textContent = "Edit Banner";
  document.getElementById("editType").value = "banner";
  document.getElementById("editId").value = id;
  document.getElementById("bannereditTitle").value = title;
  document.getElementById("bannereditContent").value = content;
  document.getElementById("bannereditPosition").value = position;
  prefillDropzoneImage(imagePath);
  

  hideAllFormFields();
  document.getElementById("bannerFields").style.display = "block";
  openModal();
}

async function saveBanner() {
  // Clear previous errors
  document.getElementById("bannerTitleError").style.display = "none";
  document.getElementById("bannerContentError").style.display = "none";
  document.getElementById("bannerImageError").style.display = "none";
  
  const id = document.getElementById("editId").value;
  const title = document.getElementById("bannereditTitle").value.trim();
  const content = document.getElementById("bannereditContent").value.trim();
  const position = document.getElementById("bannereditPosition").value;
  
  let hasError = false;
  
  // Validation
  if (!title) {
    document.getElementById("bannerTitleError").textContent = "Title is required";
    document.getElementById("bannerTitleError").style.display = "block";
    document.getElementById("bannereditTitle").focus();
    hasError = true;
  } else if (title.length < 3) {
    document.getElementById("bannerTitleError").textContent = "Title must be at least 3 characters long";
    document.getElementById("bannerTitleError").style.display = "block";
    document.getElementById("bannereditTitle").focus();
    hasError = true;
  }
  
  if (!content) {
    document.getElementById("bannerContentError").textContent = "Content is required";
    document.getElementById("bannerContentError").style.display = "block";
    if (!hasError) document.getElementById("bannereditContent").focus();
    hasError = true;
  } else if (content.length < 10) {
    document.getElementById("bannerContentError").textContent = "Content must be at least 10 characters long";
    document.getElementById("bannerContentError").style.display = "block";
    if (!hasError) document.getElementById("bannereditContent").focus();
    hasError = true;
  }
  
  if (image_name.length === 0) {
    document.getElementById("bannerImageError").textContent = "At least one image is required";
    document.getElementById("bannerImageError").style.display = "block";
    hasError = true;
  }

  const payload = {
    title,
    content,
    image_path: image_name.join(","),
    position,
  };

  let action = "add_banner";
  if (id) {
    payload.id = id;
    action = "update_banner";
  }

  const res = await fetch(`../api/admin.php?action=${action}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload),
  });

  const data = await res.json();

  if (data.success) {
    closeModal();
   toastr.success(id ? "Banner updated" : "Banner added");
   setTimeout(() => { 
    location.reload();
   },1000);
  } else {
    showNotification(data.message, "error");
  }
}

async function deleteBanner(id) {
  if (!confirm("Delete banner?")) return;

  const res = await fetch(`../api/admin.php?action=delete_banner&id=${id}`, {
    method: "DELETE",
  });
  const data = await res.json();

  if (data.success) {
    showNotification("Banner deleted", "success");
    location.reload();
  }
}

/* ================= DROPZONE ================= */
Dropzone.options.bannerDropzone = {
  maxFilesize: 5,
  acceptedFiles: "image/*",
  addRemoveLinks: true,

  init: function () {
    bannerDropzoneInstance = this;
    this.on("success", (file, response) => {
      const res =
        typeof response === "string" ? JSON.parse(response) : response;

      if (res.status) {
        image_name.push(res.image_path);
        showNotification("Image uploaded", "success");
      } else {
        showNotification(res.message, "error");
      }
    });

    this.on("removedfile", () => {
      image_name = [];
    });
  },
};
/* ================= CHARTS ================= */
function initializeCharts() {
  console.log("Charts initialized");
}
function prefillDropzoneImage(imagePath) {
  if (!bannerDropzoneInstance || !imagePath) return;

  bannerDropzoneInstance.removeAllFiles(true);
  image_name = [];

  // ✅ comma separated images
  const images = imagePath.split(",").map((img) => img.trim());

  console.log("Prefilling ALL images:", images);

  images.forEach((img) => {
    const mockFile = {
      name: img.split("/").pop(),
      size: 123456,
      accepted: true,
    };

    bannerDropzoneInstance.emit("addedfile", mockFile);
    bannerDropzoneInstance.emit("thumbnail", mockFile, "../" + img);
    bannerDropzoneInstance.emit("complete", mockFile);

    bannerDropzoneInstance.files.push(mockFile);
    image_name.push(img); // ✅ keep in sync
  });
}

