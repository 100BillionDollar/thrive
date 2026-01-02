<?php include_once 'includes/header.php'; ?>
            <section id="whoweare-section" class="content-section">
                <!-- Who We Are Management -->
                <div class="card">
                    <div class="card-header">
                        <h3 >Who We Are Management</h3>
                        <button class="btn btn-primary" onclick="addWhoweareItem()">Add New Item</button>
                    </div>
                    <div class="card-content">
                        <div class="whoweare-grid" id="whoweareGrid">
                            <?php foreach ($data['who_we_are'] as $item): ?>
                                <div class="row whoweare-item-admin">
                                    <div class="col-md-4">
                                       <?php
                                    $firstImage = '';
                                    if (!empty($item['image_path'])) {
                                        $images = explode(',', $item['image_path']);
                                        $firstImage = trim($images[0]);
                                    }?>
                                            <div class="banner-preview">
                                        <img src="../<?php echo htmlspecialchars($firstImage); ?>" alt="<?php echo htmlspecialchars($banner['title']); ?>">
                                    </div>
                                    </div>
                                    <div class="col-md-8">
                                    <div class="whoweare-info">
                                        <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                                        <p><?php echo $item['content']; ?></p>
                                        <div class="whoweare-actions">
                                           <button class="btn btn-sm btn-outline edit-whoweare-btn"
                                        data-id="<?php echo htmlspecialchars($item['id']); ?>"
                                        data-title="<?php echo htmlspecialchars($item['title']); ?>"
                                        data-content="<?php echo htmlspecialchars($item['content']); ?>"
                                        data-image="<?php echo htmlspecialchars($item['image_path']); ?>"
                                        data-status="<?php echo htmlspecialchars($item['status']); ?>">
                                        Edit
                                        </button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteWhoweareItem(<?php echo $item['id']; ?>)">Delete</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
<!-- Modal for editing content -->
<div id="whoweareEditModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="whoweareModalTitle">Edit Content</h3>
            <button class="whoweare-modal-close" onclick="whowearecloseModal()">&times;</button>
        </div>
        <div class="modal-body">
                <div class="mb-4">
                        <form action="upload.php" class="dropzone form-control" id="whoweareDropzone"></form>
                        <div class="error" id="whoweareImageError" style="color:red; display:none;">At least one image is required.</div>
                    </div>
            <form id="whoweareEditForm">
                <input type="hidden" id="whoweareeditType" value="">
                <input type="hidden" id="whoweareeditId" value="">
                
                <!-- Who We Are Fields -->
                <div  class="form-fields" >
                    <div class="form-group">
                        <label for="whoweareeditTitle">Title</label>
                        <input type="text" id="whoweareeditTitle" class="form-control">
                        <div class="error" id="whoweareTitleError" style="color:red; display:none;">Title is required.</div>
                    </div>
                    <div class="form-group">
                        <label for="whoweareeditContent">Description</label>
                        <div id="whoweareeditContent" class="form-control" style="height: 200px;"></div>
                        <div class="error" id="whoweareContentError" style="color:red; display:none;">Description is required.</div>

                    </div>
                    <div class="form-group">
                        <label for="whoweareeditStatus">Status</label>
                        <select id="whoweareeditStatus" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" onclick="whowearecloseModal()">Cancel</button>
                    <button type="button" onclick="saveWhoweare()" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Footer -->
<?php include_once 'includes/footer.php'; ?>