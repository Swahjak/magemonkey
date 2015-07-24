USE pooltopp_staging_to_live;

DROP TABLE ebizmarts_abandonedcart_abtesting;
DROP TABLE ebizmarts_abandonedcart_popup;
DROP TABLE ebizmarts_autoresponder_backtostock;
DROP TABLE ebizmarts_autoresponder_backtostock_alert;

DELETE FROM core_resource WHERE code = 'ebizmarts_abandonedcart_setup' OR code = 'ebizmarts_autoresponder_setup'