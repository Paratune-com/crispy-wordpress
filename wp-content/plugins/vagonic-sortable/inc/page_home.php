<div class="wrapper d-flex align-items-stretch">
    <!-- Vagonic Sidebar -->
    <nav id="vagonicSidebar" class="shadow">
      <div>
        <!-- Toggle Sidebar -->
        <div class="custom-menu">
          <button type="button" id="vagonicSidebarCollapse" class="btn btn-primary">
          </button>
        </div>
        <div class="d-flex justify-content-center">
          <ul class="nav nav-pills nav-pills-primary" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" href="#category-panel" role="tab" data-toggle="tab">
                <i class="material-icons">category</i>
                <?php _e('category', 'vagonic-sortable-lite'); ?>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#tag-panel" role="tab" data-toggle="tab">
                <i class="material-icons">local_offer</i>
                <?php _e('tag', 'vagonic-sortable-lite'); ?>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="vagonicSidebarCollapseAuto">
                <i class="material-icons">backspace</i>
                <?php _e('hide', 'vagonic-sortable-lite'); ?>
              </a>
            </li>
          </ul>
        </div>
        <div class="tab-content">
          <div class="tab-pane active" id="category-panel">
            <form id="frm_category_vagonic_sortable_lite">
              <input type="hidden" name="cat_id" value="0">
              <div class="form-group">
                <input type="text" class="form-control search" name="search" id="searchCategory" placeholder="<?php _e('search_category', 'vagonic-sortable-lite'); ?>">
              </div>
              <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title" id="panelTitleCategory">
                      <a data-toggle="collapse" href="#filtersCategory"><i class="material-icons mr-1 mb-1">filter_alt</i><span class="span-text-filters">
                          <?php _e('filters', 'vagonic-sortable-lite'); ?>
                        </span></a>
                    </div>
                  </div>
                  <div id="filtersCategory" class="panel-collapse collapse">
                    <div class="d-flex justify-content-end">
                      <div class="toggle-price">
                        <div class="form-check form-check-inline">
                          <label for="checkPriceForCat" class="form-check-label"><?php _e('without_price', 'vagonic-sortable-lite'); ?></label>
                          <input id="checkPriceForCat" class="form-check-input" type="checkbox" data-toggle="toggle" data-style="ml-2 mr-3" data-on="<?php _e('show', 'vagonic-sortable-lite'); ?>" data-off="<?php _e('dont_show', 'vagonic-sortable-lite'); ?>" data-onstyle="success" data-offstyle="danger" checked>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-end">
                      <div class="toggle-stock">
                        <div class="form-check form-check-inline">
                          <label for="checkStockForCat" class="form-check-label"><?php _e('out_of_stock', 'vagonic-sortable-lite'); ?></label>
                          <input id="checkStockForCat" class="form-check-input" type="checkbox" data-toggle="toggle" data-style="ml-2 mr-3" data-on="<?php _e('show', 'vagonic-sortable-lite'); ?>" data-off="<?php _e('dont_show', 'vagonic-sortable-lite'); ?>" data-onstyle="success" data-offstyle="danger" checked>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="list-group" id="categoryList">
              </div>
              <div class="button-vagonic d-flex justify-content-end div-save">
                <button class="btn btn-success" type="submit" (click)="refresh()" [disabled]="loading">
                  <i class="material-icons mr-2">save</i>
                  <?php _e('save', 'vagonic-sortable-lite'); ?>
                </button>
              </div>
            </form>
          </div>
          <div class="tab-pane" id="tag-panel">
              <div class="panel-group">
                Visit for pro: <a href="https://vagonic.com/">Vagonic Sortable Pro</a>
              </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
      <form id="frm_products_vagonic_sortable_lite">
        <input type="hidden" name="action" value="vagonic_sortable_lite_save">
        <div id="product_items" class="container-items d-flex align-items-stretch flex-wrap">
        </div>
      </form>
    </div>
  </div>