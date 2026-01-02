let image_nameEcosystem = [];
let ecosystemDropzoneInstance = null;
/* ================= ecosystemS ================= */
function addEcosystemItem() {
  image_nameEcosystem = [];

  document.getElementById("ecosystemModalTitle").textContent = "Add ecosystem";
  document.getElementById("ecosystemeditType").value = "ecosystem";
  document.getElementById("ecosystemeditId").value = "";
  document.getElementById("ecosystemeditTitle").value = "";
  document.getElementById("ecosystemeditContent").value = "";
  document.getElementById("ecosystemeditStatus").value = "1";
if (ecosystemDropzoneInstance) {
    ecosystemDropzoneInstance.removeAllFiles(true);
}
  hideAllFormFields();
  ecosystemOpenModal();
}

function editEcosystemItem(id, title, content, imagePath, position = 1) {
  // image_nameEcosystem];
   image_nameEcosystem.push(...imagePath.split(",").map(img => img.trim()));
  console.log("Editing ecosystem with image:", position);

  document.getElementById("ecosystemModalTitle").textContent = "Edit ecosystem";
  document.getElementById("ecosystemeditType").value = "ecosystem";
  document.getElementById("ecosystemeditId").value = id;
  document.getElementById("ecosystemeditTitle").value = title;
  document.getElementById("ecosystemeditContent").value = content;
  document.getElementById("ecosystemeditStatus").value = position;
  ecoSYsteimageMock(imagePath);
  

  hideAllFormFields();
//   document.getElementById("ecosystemFields").style.display = "block";
  ecosystemOpenModal();
}

async function saveEcosystem() {
  // Clear previous errors
  document.getElementById("ecosystemTitleError").style.display = "none";
  document.getElementById("ecosystemContentError").style.display = "none";
  document.getElementById("ecosystemImageError").style.display = "none";
  
  const id = document.getElementById("ecosystemeditId").value;
  const title = document.getElementById("ecosystemeditTitle").value.trim();
  const content = document.getElementById("ecosystemeditContent").value.trim();
  const status = document.getElementById("ecosystemeditStatus").value;
  
  let hasError = false;
  
  // Validation
  if (!title) {
    document.getElementById("ecosystemTitleError").textContent = "Name is required";
    document.getElementById("ecosystemTitleError").style.display = "block";
    document.getElementById("ecosystemeditTitle").focus();
    hasError = true;
  } else if (title.length < 3) {
    document.getElementById("ecosystemTitleError").textContent = "Name must be at least 3 characters long";
    document.getElementById("ecosystemTitleError").style.display = "block";
    document.getElementById("ecosystemeditTitle").focus();
    hasError = true;
  }
  
  if (!content) {
    document.getElementById("ecosystemContentError").textContent = "Description is required";
    document.getElementById("ecosystemContentError").style.display = "block";
    if (!hasError) document.getElementById("ecosystemeditContent").focus();
    hasError = true;
  } else if (content.length < 10) {
    document.getElementById("ecosystemContentError").textContent = "Description must be at least 10 characters long";
    document.getElementById("ecosystemContentError").style.display = "block";
    if (!hasError) document.getElementById("ecosystemeditContent").focus();
    hasError = true;
  }
  
  if (image_nameEcosystem.length === 0) {
    document.getElementById("ecosystemImageError").textContent = "At least one image is required";
    document.getElementById("ecosystemImageError").style.display = "block";
    hasError = true;
  }
  
  if (hasError) return;
  
  console.log("Saving ecosystem with images:", image_nameEcosystem);
  console.log("Title:", title);

  const payload = {
    name: title,
    content,
    description: content,
    image_path: image_nameEcosystem.join(","),
    status,
  };

  let action = "add_ecosystem";
  if (id) {
    payload.id = id;
    action = "update_ecosystem";
  }

  const res = await fetch(`../api/admin.php?action=${action}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload),
  });

  const data = await res.json();

  if (data.success) {
    ecosystemcloseModal();
   toastr.success(id ? "ecosystem updated" : "ecosystem added");
   setTimeout(() => { 
    location.reload();
   },1000);
  } else {
    showNotification(data.message, "error");
  }
}

async function deleteEcosystemItem(id) {
  if (!confirm("Delete ecosystem?")) return;

  const res = await fetch(`../api/admin.php?action=delete_ecosystem&id=${id}`, {
    method: "DELETE",
  });
  const data = await res.json();

  if (data.success) {
    showNotification("ecosystem deleted", "success");
    location.reload();
  }
}

/* ================= DROPZONE ================= */
Dropzone.options.ecosystemDropzone = {
  maxFilesize: 5,
  acceptedFiles: "image/*",
  addRemoveLinks: true,

  init: function () {
    ecosystemDropzoneInstance = this;
    this.on("success", (file, response) => {
      const res =
        typeof response === "string" ? JSON.parse(response) : response;

      if (res.status) {
        image_nameEcosystem.push(res.image_path);
        showNotification("Image uploaded", "success");
      } else {
        showNotification(res.message, "error");
      }
    });

    this.on("removedfile", () => {
      image_nameEcosystem = [];
    });
  },
};


function ecosystemOpenModal() {
  // Clear any previous errors
  document.getElementById("ecosystemTitleError").style.display = "none";
  document.getElementById("ecosystemContentError").style.display = "none";
  document.getElementById("ecosystemImageError").style.display = "none";
  
  document.getElementById("ecosystemEditModal").style.display = "block";
  document.body.style.overflow = "hidden";
}




function ecosystemcloseModal() {
  document.getElementById("ecosystemEditModal").style.display = "none";
  document.body.style.overflow = "auto";
}

function ecoSYsteimageMock(imagePath) {
  if (!ecosystemDropzoneInstance || !imagePath) return;

  ecosystemDropzoneInstance.removeAllFiles(true);
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

    ecosystemDropzoneInstance.emit("addedfile", mockFile);
    ecosystemDropzoneInstance.emit("thumbnail", mockFile, "../" + img);
    ecosystemDropzoneInstance.emit("complete", mockFile);

    ecosystemDropzoneInstance.files.push(mockFile);
    image_name.push(img); // ✅ keep in sync
  });
}
