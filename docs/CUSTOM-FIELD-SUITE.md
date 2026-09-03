# Custom Field Suite maintenance

Custom Field Suite must remain in place for this site. Do not replace it with ACF, atshift Fields, or another plugin.

## Maintained build

- Plugin version: `2.6.8-wiz.2`
- Update URI: `https://github.com/wiz-develop/yzwa`
- Staging data check: 7 field groups, 81 fields, and 63 fields with stored values.
- The build carries the maintained PHP and modern WordPress compatibility changes while preserving the `CFS()` API, field definitions, templates, and database data.

## Reapplication

1. Back up the database and current `wp-content/plugins/custom-field-suite` directory.
2. Install the complete `custom-field-suite` directory from this branch; do not overwrite it with the abandoned public 2.6.2 release.
3. Confirm the header still reads `2.6.8-wiz.2` and contains the repository `Update URI`.
4. Open a representative page in the editor, load existing CFS values, save without content changes, and verify the public page.
5. Check the PHP log for Fatal, Warning, Deprecated, and Notice entries.

The tested package retained outside Git is `work/yzwa-migration/packages/official/custom-field-suite-2.6.8-wiz.2.zip`, SHA-256 `edd8f568fd2c86a01cbc84ea808382a42355284db7c3f42775f6506997107f03`.
