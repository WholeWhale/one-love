<div class="wrap">

    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <form method="post" action="<?php echo esc_html( admin_url( 'admin-post.php' ) ); ?>">

      <?php foreach ($forms as $form): ?>
        <h2><?php echo $form['name']; ?></h2>
        <table>
          <thead>
            <tr>
              <th>Field name</th>
              <th>Salesforce Object</th>
              <th>Field Name</th>
              <th>Is Upsert Key</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($form['fields'] as $field): ?>
            <tr>
              <td><?php echo $field['name']; ?></td>
              <td><input type="text" name="forms[<?php echo $form['id']; ?>][<?php echo $field['name']; ?>][object]" value="<?php echo $field['object']; ?>" /></td>
              <td><input type="text" name="forms[<?php echo $form['id']; ?>][<?php echo $field['name']; ?>][field]" value="<?php echo $field['field']; ?>" /></td>
              <td><input type="checkbox" name="forms[<?php echo $form['id']; ?>][<?php echo $field['name']; ?>][upsert]" value="yes" <?php if ($field['upsert-key']) echo 'checked="checked"'; ?>/></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php endforeach; ?>

      <?php
        wp_nonce_field(CF7SF_Settings::NONCE, CF7SF_Settings::NONCE_MSG);
        submit_button();
      ?>
    </form>

</div><!-- .wrap -->
