<?php
if (!defined('ABSPATH')) {
	exit;
}

$values = array();
foreach (array_keys(duo_obituary_fields()) as $key) {
	$values[$key] = duo_obituary_option($content, $key);
}
$auto_title = $content->title ? $content->title : implode('/', array_filter(array($values['affiliation'], $values['deceased_name'], $values['death_date'])));
?>
<div id="duo-obituary-editor" class="duo-obituary duo-obituary-editor">
	<form class="kboard-form duo-obituary-form" method="post"
		action="<?php echo esc_url($url->getContentEditorExecute()) ?>" enctype="multipart/form-data"
		onsubmit="return duoObituaryBeforeSubmit(this) && (typeof kboard_editor_execute !== 'function' || kboard_editor_execute(this));">
		<?php $skin->editorHeader($content, $board) ?>
		<input type="hidden" id="duo-obituary-title" name="title"
			value="<?php echo esc_attr($auto_title ? $auto_title : '부고') ?>">
		<input type="hidden" name="kboard_content" value="">

		<div class="duo-obituary-field duo-obituary-field-photo">
			<label>사진</label>
			<div class="duo-obituary-thumbnail-uploader <?php echo $content->thumbnail_file ? 'has-image' : '' ?>">
				<!-- Hidden input for file selection -->
				<input type="file" id="duo-obituary-thumbnail" name="thumbnail" accept="image/*" class="duo-obituary-thumbnail-input" style="display: none;">
				
				<!-- Drag & Drop / Click Placeholder -->
				<div class="duo-obituary-thumbnail-placeholder">
					<div class="placeholder-icon">
						<svg viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
							<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
							<circle cx="8.5" cy="8.5" r="1.5"></circle>
							<polyline points="21 15 16 10 5 21"></polyline>
						</svg>
					</div>
					<div class="placeholder-text">클릭하거나 이미지를 드래그하여 업로드하세요</div>
					<div class="placeholder-hint">JPG, PNG, GIF (최대 10MB)</div>
				</div>

				<!-- Image Preview Container -->
				<div class="duo-obituary-thumbnail-preview-container">
					<img class="duo-obituary-thumbnail-preview" src="<?php echo $content->thumbnail_file ? esc_url($content->getThumbnail()) : '' ?>" alt="Thumbnail Preview">
					<button type="button" class="duo-obituary-thumbnail-remove" title="이미지 삭제"
						data-delete-url="<?php echo ($content->uid && $content->thumbnail_file) ? esc_url($url->getDeleteURLWithAttach($content->uid, 'thumbnail')) : '' ?>">
						<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<line x1="18" y1="6" x2="6" y2="18"></line>
							<line x1="6" y1="6" x2="18" y2="18"></line>
						</svg>
					</button>
				</div>
			</div>
		</div>

		<div class="duo-obituary-field">
			<label for="duo-affiliation">소속</label>
			<input type="text" id="duo-affiliation" name="kboard_option_affiliation"
				value="<?php echo esc_attr($values['affiliation']) ?>">
		</div>

		<div class="duo-obituary-field required">
			<label for="duo-deceased-name">고인명 <span>*</span></label>
			<input type="text" id="duo-deceased-name" name="kboard_option_deceased_name"
				value="<?php echo esc_attr($values['deceased_name']) ?>" required>
		</div>

		<div class="duo-obituary-field required">
			<label for="duo-chief-mourner">상주명 <span>*</span></label>
			<textarea id="duo-chief-mourner" name="kboard_option_chief_mourner" rows="4"
				required><?php echo esc_textarea($values['chief_mourner']) ?></textarea>
		</div>

		<div class="duo-obituary-field-grid">
			<div class="duo-obituary-field">
				<label for="duo-death-date">별세일</label>
				<input type="datetime-local" id="duo-death-date" name="kboard_option_death_date"
					value="<?php echo esc_attr(str_replace(' ', 'T', $values['death_date'])) ?>">
			</div>
			<div class="duo-obituary-field">
				<label for="duo-coffin-date">입관일</label>
				<input type="datetime-local" id="duo-coffin-date" name="kboard_option_coffin_date"
					value="<?php echo esc_attr(str_replace(' ', 'T', $values['coffin_date'])) ?>">
			</div>
			<div class="duo-obituary-field required">
				<label for="duo-funeral-date">발인일 <span>*</span></label>
				<input type="datetime-local" id="duo-funeral-date" name="kboard_option_funeral_date"
					value="<?php echo esc_attr(str_replace(' ', 'T', $values['funeral_date'])) ?>" required>
			</div>
		</div>

		<div class="duo-obituary-field">
			<label for="duo-place">장례식장</label>
			<input type="text" id="duo-place" name="kboard_option_place"
				value="<?php echo esc_attr($values['place']) ?>">
		</div>

		<div class="duo-obituary-field">
			<label for="duo-burial-place">장지</label>
			<input type="text" id="duo-burial-place" name="kboard_option_burial_place"
				value="<?php echo esc_attr($values['burial_place']) ?>">
		</div>

		<?php if (!is_user_logged_in()): ?>
			<div class="duo-obituary-field required">
				<label for="kboard-input-password"><?php echo esc_html__('Password', 'kboard') ?> <span>*</span></label>
				<input type="password" id="kboard-input-password" name="password"
					value="<?php echo esc_attr($content->password) ?>" required>
			</div>
		<?php endif ?>

		<div class="duo-obituary-control">
			<div class="left">
				<?php if ($content->uid): ?>
					<a href="<?php echo esc_url($url->getDocumentURLWithUID($content->uid)) ?>"
						class="duo-obituary-button secondary"><?php echo esc_html__('Back', 'kboard') ?></a>
				<?php endif ?>
				<a href="<?php echo esc_url($url->getBoardList()) ?>"
					class="duo-obituary-button secondary"><?php echo esc_html__('List', 'kboard') ?></a>
			</div>
			<div class="right">
				<?php if ($board->isWriter()): ?>
					<button type="submit" class="duo-obituary-button primary">저장</button>
				<?php endif ?>
			</div>
		</div>
	</form>
</div>
<?php
wp_enqueue_style('duo-obituary-style', "{$skin_path}/style.css", array(), duo_obituary_asset_version($skin_dir, 'style.css'));
wp_enqueue_script('duo-obituary-script', "{$skin_path}/script.js", array(), duo_obituary_asset_version($skin_dir, 'script.js'), true);
?>