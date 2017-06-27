<div class="wrap">
  <h1>API Keys</h1>
  <h2>Saved keys</h2>
  <table class="form-table">
    <tbody>
      <?php foreach ($keys as $name => $key) : ?>
        <tr>
          <th><?php echo $name; ?></th>
          <td><?php echo $key; ?> </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
  </table>
  <h2>Add or update a key</h2>
  <p>To update a key, re-add it here.</p>
  <form method="post" action="<?php echo esc_html(admin_url('admin-post.php')); ?>">
    <input type="text" name="name" placeholder="Key name (ex. FACBOOK_APP_ID)" class="regular-text" />
    <input type="text" name="key" placeholder="Key" class="regular-text" />

    <?php
      wp_nonce_field(WPKeystore_SettingsPage::NONCE, WPKeystore_SettingsPage::NONCE_MSG);
      submit_button('Add key', 'primary', null, false);
    ?>
  </form>
</div>
