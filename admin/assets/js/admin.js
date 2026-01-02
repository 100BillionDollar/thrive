/* ================= GLOBAL STATE ================= */
let currentSection = "dashboard";
let subscribersData = [];
let notificationsDropdown = null;
let image_name = [];
let bannerDropzoneInstance = null;
toastr.options = {
  closeButton: true,
  progressBar: true,
  positionClass: "toast-top-right",
  timeOut: "3000",
  extendedTimeOut: "1000",
  preventDuplicates: true,
};

/* ================= INIT ================= */
document.addEventListener("DOMContentLoaded", () => {
  initializeDashboard();
  initializeNotifications();
  loadSubscribers();
  initializeCharts();
  updateDateTime();
  setInterval(updateDateTime, 1000);
});
function showNotification(msg, type = "info") {
  const n = document.createElement("div");

  n.className = `notification notification-${type}`;
  n.textContent = msg;
  document.body.appendChild(n);
  setTimeout(() => n.remove(), 3000);
}
/* ================= SECTION NAV ================= */
function showSection(sectionName) {
  document.querySelectorAll(".content-section").forEach((sec) => {
    sec.classList.remove("active");
  });

  const target = document.getElementById(sectionName + "-section");
  if (target) target.classList.add("active");

  document.querySelectorAll(".nav-link").forEach((link) => {
    link.classList.remove("active");
  });

  currentSection = sectionName;
}

/* ================= DASHBOARD ================= */
function initializeDashboard() {
  const editForm = document.getElementById("editForm");
  if (editForm) {
    editForm.addEventListener("submit", (e) => {
      e.preventDefault();
      saveContentChanges();
    });
  }
}

/* ================= NOTIFICATIONS ================= */
function initializeNotifications() {
  notificationsDropdown = document.getElementById("notificationsDropdown");

  document.addEventListener("click", (e) => {
    if (
      !e.target.closest(".notification-btn") &&
      !e.target.closest(".notifications-dropdown")
    ) {
      closeNotifications();
    }
  });
}

function toggleNotifications() {
  if (!notificationsDropdown) return;
  notificationsDropdown.classList.toggle("show");
}
function closeNotifications() {
  if (notificationsDropdown) notificationsDropdown.classList.remove("show");
}

/* ================= DATE TIME ================= */
function updateDateTime() {
  const el = document.getElementById("dateTime");
  if (!el) return;

  el.textContent = new Date().toLocaleDateString("en-US", {
    weekday: "short",
    year: "numeric",
    month: "short",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
}

/* ================= SUBSCRIBERS ================= */
async function loadSubscribers() {
  try {
    const res = await fetch("../api/admin.php?action=get_subscribers");
    const data = await res.json();

    if (data.success && Array.isArray(data.data)) {
      subscribersData = data.data;
    } else {
      subscribersData = [];
    }

    displaySubscribers(subscribersData);
  } catch (err) {
    console.error("Subscriber load error:", err);
    subscribersData = [];
    displaySubscribers([]);
  }
}

function displaySubscribers(list) {
  if (!Array.isArray(list)) return;

  const tbody = document.getElementById("subscribersList");
  if (!tbody) return;

  tbody.innerHTML = "";

  list.forEach((s) => {
    tbody.innerHTML += `
            <tr>
                <td>${s.id}</td>
                <td>${s.email}</td>
                <td><span class="status-badge ${s.status}">${
      s.status
    }</span></td>
                <td>${formatDate(s.created_at)}</td>
                <td>
                    <button onclick="deleteSubscriber(${s.id})">🗑</button>
                </td>
            </tr>
        `;
  });
}

async function deleteSubscriber(id) {
  if (!confirm("Delete subscriber?")) return;

  const res = await fetch(
    `../api/admin.php?action=delete_subscriber&id=${id}`,
    {
      method: "DELETE",
    }
  );
  const data = await res.json();

  if (data.success) {
    subscribersData = subscribersData.filter((s) => s.id !== id);
    displaySubscribers(subscribersData);
    showNotification("Subscriber deleted", "success");
  }
}

/* ================= MODAL ================= */
function openModal() {
  // Clear any previous errors
  const bannerTitleError = document.getElementById("bannerTitleError");
  const bannerContentError = document.getElementById("bannerContentError");
  const bannerImageError = document.getElementById("bannerImageError");
  
  if (bannerTitleError) bannerTitleError.style.display = "none";
  if (bannerContentError) bannerContentError.style.display = "none";
  if (bannerImageError) bannerImageError.style.display = "none";
  
  document.getElementById("editModal").style.display = "block";
  document.body.style.overflow = "hidden";
}

function closeModal() {
  document.getElementById("editModal").style.display = "none";
  document.body.style.overflow = "auto";
}

window.onclick = (e) => {
  const modal = document.getElementById("editModal");
  if (modal && e.target === modal) closeModal();
};

/* ================= CONTENT SAVE ================= */
async function saveContentChanges() {
  const type = document.getElementById("editType").value;

  if (type === "banner") {
    await saveBanner();
    return;
  }

  showNotification("Unsupported content type", "warning");
}



/* ================= HELPERS ================= */
function hideAllFormFields() {
  const banner = document.getElementById("bannerFields");
  if (banner) banner.style.display = "none";
}

function showNotification(msg, type = "info") {
  const n = document.createElement("div");
  n.className = `notification notification-${type}`;
  n.textContent = msg;
  document.body.appendChild(n);
  setTimeout(() => n.remove(), 3000);
}

function formatDate(date) {
  return new Date(date).toLocaleDateString("en-US", {
    year: "numeric",
    month: "short",
    day: "numeric",
  });
}

/* ================= SETTINGS ================= */
document.addEventListener("DOMContentLoaded", () => {
  const settingsForm = document.getElementById("settingsForm");
  if (settingsForm) {
    settingsForm.addEventListener("submit", saveSettings);
  }
});

function saveSettings(event) {
  event.preventDefault();
  
  const formData = new FormData(event.target);
  const data = Object.fromEntries(formData);
  
  // Convert checkbox to boolean
  data.maintenance_mode = document.getElementById("maintenanceMode").checked;
  
  fetch("../api/admin.php?action=save_settings", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((result) => {
      if (result.success) {
        toastr.success(result.message || "Settings saved successfully");
      } else {
        toastr.error(result.message || "Failed to save settings");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      toastr.error("An error occurred while saving settings");
    });
}

