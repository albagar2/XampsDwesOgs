TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER trg_crear_fidelidad_cliente\nAFTER INSERT ON Cliente\nFOR EACH ROW\nBEGIN\n    INSERT INTO Fidelidad_Puntos (id_cliente, saldo_puntos)\n    VALUES (NEW.id_cliente, 0);\nEND'
sql_modes=1098907648
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_general_ci'
db_cl_names='utf8mb4_general_ci'
created=1765914390999728
