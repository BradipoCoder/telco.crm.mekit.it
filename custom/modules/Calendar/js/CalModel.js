/**
 * Default CAL definition
 *
 * @type {object}
 */
var CAL = {
  /* GENERIC */
  view:     null,
  style:    null,
  t_step:   null,
  current_user_id:   null,
  current_user_name:   null,
  time_format:   null,
  enable_repeat:   null,
  items_draggable:   null,
  items_resizable:   null,
  cells_per_day:   null,
  current_params:   null,
  dashlet:   null,
  grid_start_ts:   null,
  scroll_slot:   null,
  print:   false,
  slot_height: 14,
  dropped: 0,
  records_openable: true,
  moved_from_cell: "",
  deleted_id: "",
  deleted_module: "",
  tmp_header: "",
  disable_creating: false,
  record_editable: false,
  shared_users: {},
  shared_users_count: 0,
  script_evaled: false,
  editDialog: false,
  settingsDialog: false,
  sharedDialog: false,
  update_dd: null,
  dd_registry: {},
  resize_registry: {},
  dom: null,
  get: null,
  query: null,

  /* FIELDS */
  field_list: [],
  field_disabled_list: [],

  /* LABELS */
  lbl_create_new:   null,
  lbl_create_new_type: {},
  lbl_edit:   null,
  lbl_saving:   null,
  lbl_loading:   null,
  lbl_sending:   null,
  lbl_confirm_remove:   null,
  lbl_confirm_remove_all_recurring:   null,
  lbl_error_saving:   null,
  lbl_error_loading:   null,
  lbl_repeat_limit_error:   null,

  /* DATE */
  year:   null,
  month:   null,
  day:   null,

  /* ACL */
  act_types:   {
    Meetings:     'meeting',
    Calls:        'call',
    Tasks:        'task'
  },

  /* W/H */
  basic: {
    min_width: null,
    min_height: null,
    items: {}
  }
};