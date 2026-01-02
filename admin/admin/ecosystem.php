<?php include_once 'includes/header.php'; ?>
<?php $ecosystemHeading = $dashboard->getSetting('ecosystem_heading') ?: 'ThriveHQ Ecosystem'; ?>
<!-- Ecosystem Section -->
            <section id="ecosystem-section" class="content-section">
                <div class="card">
                    <div class="card-header">
                        <h3><?php echo htmlspecialchars($ecosystemHeading); ?></h3>
                        <button class="btn btn-primary" onclick="addEcosystemItem()">Add New Item</button>
                    </div>
                    <div class="card-content">
                        <div class="ecosystem-grid" id="ecosystemGrid">
                            <?php foreach ($data['ecosystem'] as $item): ?>
                                  <?php
                                    $ecoFirstImage = '';
                                    if (!empty($item['image_path'])) {
                                        $images = explode(',', $item['image_path']);
                                        $ecoFirstImage = trim($images[0]);
                                    }?>
                                <div class="ecosystem-item">
                                    <div class="ecosystem-icon">
                                        <img src="../<?php echo htmlspecialchars($ecoFirstImage); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="ecosystem-image w-100 h-100 object-fit-cover">
                                    </div>
                                    <div class="ecosystem-info">
                                        <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                                        <p><?php echo htmlspecialchars($item['description']); ?></p>
                                        <div class="ecosystem-actions">
                                            <button class="btn btn-sm btn-outline" onclick="editEcosystemItem(<?php echo $item['id']; ?>, '<?php echo htmlspecialchars($item['name']); ?>', '<?php echo htmlspecialchars($item['description']); ?>', '<?php echo htmlspecialchars($item['image_path']); ?>', '<?php echo htmlspecialchars($item['status']); ?>')">Edit</button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteEcosystemItem(<?php echo $item['id']; ?>)">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
            
<div id="ecosystemEditModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="ecosystemModalTitle">Edit Content</h3>
            <button class="ecosystem-modal-close" onclick="ecosystemcloseModal()">&times;</button>
        </div>
        <div class="modal-body">
                <div class="mb-4">
                        <form action="upload.php" class="dropzone form-control" id="ecosystemDropzone"></form>
                    </div>
            <form id="editForm">
                <input type="hidden" id="ecosystemeditType" value="">
                <input type="hidden" id="ecosystemeditId" value="">
                
                <!-- Ecosystem Fields -->
                <div  class="form-fields" >
                    <div class="form-group">
                        <label for="ecosystemeditTitle">Name</label>
                        <input type="text" id="ecosystemeditTitle" class="form-control">
                        <div class="error" id="ecosystemTitleError" style="color:red; display:none;"></div>
                    </div>
                    <div class="form-group">
                        <label for="ecosystemeditContent">Description</label>
                        <textarea id="ecosystemeditContent" class="form-control" rows="4"></textarea>
                        <div class="error" id="ecosystemContentError" style="color:red; display:none;"></div>
                    </div>
                <div class="form-group">
                        <label for="ecosystemeditStatus">Status</label>
                        <select id="ecosystemeditStatus" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <label for="ecosystemeditPosition">Position</label>
                        <input type="number" id="ecosystemeditPosition" class="form-control" min="1" max="3">
                    </div>
                </div> -->
                <div class="error" id="ecosystemImageError" style="color:red; display:none;"></div>
                
                <div class="modal-actions">
                    <button type="button" class="btn btn-outline" onclick="ecosystemcloseModal()">Cancel</button>
                    <button type="button" onclick="saveEcosystem()" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>