<?php include_once 'includes/header.php'; ?>
<!-- Content Management Section -->
            <section id="content-section" class="content-section">
                <!-- Banner Management -->
                <div class="card">
                    <div class="card-header">
                        <h3>Banner Management</h3>
                        <button class="btn btn-primary" onclick="addBanner()">Add New Banner</button>
                    </div>
                    <div class="card-content">
                        <div class="banner-grid" id="bannerGrid">
                            <?php foreach ($data['banners'] as $banner): ?>
                                <?php
                                    $firstImage = '';
                                    if (!empty($banner['image_path'])) {
                                        $images = explode(',', $banner['image_path']);
                                        $firstImage = trim($images[0]);
                                    }?>
                                <div class="banner-item-admin">
                                    <div class="banner-preview">
                                        <img src="../<?php echo htmlspecialchars($firstImage); ?>" alt="<?php echo htmlspecialchars($banner['title']); ?>">
                                    </div>
                                    <div class="banner-info">
                                        <h4><?php echo htmlspecialchars($banner['title']); ?></h4>
                                        <p><?php echo htmlspecialchars($banner['content']); ?></p>
                                        <div class="banner-actions">
                                           <button class="btn btn-sm btn-outline"
                                        onclick="editBanner('<?php echo $banner['id'];?>',
                                          ' <?php echo $banner['title'];?>',
                                        '<?php echo $banner['content'];?>',
                                        '<?php echo $banner['image_path'];?>',
                                        <?php echo $banner['position'];?>)">
                                        Edit
                                        </button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteBanner(<?php echo $banner['id']; ?>)">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
<!-- Modal for editing content -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Edit Content</h3>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
                <div class="mb-4">
                        <form action="upload.php" class="dropzone form-control" id="bannerDropzone"></form>
                    </div>
            <form id="editForm">
                <input type="hidden" id="editType" value="">
                <input type="hidden" id="editId" value="">
                
                
                
                <!-- Banner Fields -->
                <div id="bannerFields" class="form-fields" style="display: none;">
                    <div class="form-group">
                        <label for="bannereditTitle">Title</label>
                        <input type="text" id="bannereditTitle" class="form-control">
                        <div class="error" id="bannerTitleError" style="color:red; display:none;"></div>
                    </div>
                    <div class="form-group">
                        <label for="bannereditContent">Content</label>
                        <textarea id="bannereditContent" class="form-control" rows="4"></textarea>
                        <div class="error" id="bannerContentError" style="color:red; display:none;"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="bannereditPosition">Position</label>
                        <input type="number" id="bannereditPosition" class="form-control" min="1" max="3">
                        <div class="error" id="bannerPositionError" style="color:red; display:none;"></div>
                    </div>
                    <div class="form-group">
                        <label for="bannereditStatus">Status</label>
                        <select id="bannereditStatus" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <div class="error" id="bannerStatusError" style="color:red; display:none;"></div>
                    </div>
                    <div class="error" id="bannerImageError" style="color:red; display:none;"></div>
                </div>
                <!-- Ecosystem Fields -->
                
                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="button" onclick="saveBanner()" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
            <?php include_once 'includes/footer.php'; ?>