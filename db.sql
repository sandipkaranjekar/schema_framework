--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: groups; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE groups (
    id bigint NOT NULL,
    group_name character varying(255),
    group_description text,
    is_active boolean DEFAULT true,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);


ALTER TABLE public.groups OWNER TO postgres;

--
-- Name: groups_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE groups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.groups_id_seq OWNER TO postgres;

--
-- Name: groups_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE groups_id_seq OWNED BY groups.id;


--
-- Name: groups_privileges; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE groups_privileges (
    groups_id bigint,
    privilege_id bigint
);


ALTER TABLE public.groups_privileges OWNER TO postgres;

--
-- Name: privileges; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE privileges (
    id bigint NOT NULL,
    privilege_name character varying(255),
    privilege_description text,
    modules_id bigint,
    is_active boolean DEFAULT true,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);


ALTER TABLE public.privileges OWNER TO postgres;

--
-- Name: privileges_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE privileges_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.privileges_id_seq OWNER TO postgres;

--
-- Name: privileges_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE privileges_id_seq OWNED BY privileges.id;


--
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE roles (
    id bigint NOT NULL,
    role_name character varying(255),
    role_description text,
    is_active boolean DEFAULT true,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- Name: roles_groups; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE roles_groups (
    roles_id bigint,
    groups_id bigint
);


ALTER TABLE public.roles_groups OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_id_seq OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE roles_id_seq OWNED BY roles.id;


--
-- Name: system_modules; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE system_modules (
    id bigint NOT NULL,
    system_module_name character varying(255),
    system_module_description text,
    system_module_order bigint,
    is_active boolean DEFAULT true,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);


ALTER TABLE public.system_modules OWNER TO postgres;

--
-- Name: system_modules_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE system_modules_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.system_modules_id_seq OWNER TO postgres;

--
-- Name: system_modules_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE system_modules_id_seq OWNED BY system_modules.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE users (
    id bigint NOT NULL,
    user_name character varying(255),
    user_email character varying(255),
    user_password character varying(255),
    user_gender character varying(255),
    user_contact_no bigint,
    user_dob date,
    user_address text,
    user_designation character varying(255),
    roles_id bigint,
    user_photo_name character varying(255),
    user_photo_type character varying(255),
    user_photo_path character varying(255),
    user_photo_size bigint,
    is_active boolean DEFAULT true,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY groups ALTER COLUMN id SET DEFAULT nextval('groups_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY privileges ALTER COLUMN id SET DEFAULT nextval('privileges_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY roles ALTER COLUMN id SET DEFAULT nextval('roles_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY system_modules ALTER COLUMN id SET DEFAULT nextval('system_modules_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- Data for Name: groups; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO groups VALUES (10, 'Tech Schema', 'Developer access', true, '2014-11-11 21:01:58.412003+05:30', '2014-11-11 21:01:58.412003+05:30');


--
-- Name: groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('groups_id_seq', 10, true);


--
-- Data for Name: groups_privileges; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO groups_privileges VALUES (10, 16);
INSERT INTO groups_privileges VALUES (10, 17);
INSERT INTO groups_privileges VALUES (10, 18);
INSERT INTO groups_privileges VALUES (10, 19);
INSERT INTO groups_privileges VALUES (10, 20);
INSERT INTO groups_privileges VALUES (10, 6);
INSERT INTO groups_privileges VALUES (10, 7);
INSERT INTO groups_privileges VALUES (10, 8);
INSERT INTO groups_privileges VALUES (10, 9);
INSERT INTO groups_privileges VALUES (10, 10);
INSERT INTO groups_privileges VALUES (10, 11);
INSERT INTO groups_privileges VALUES (10, 12);
INSERT INTO groups_privileges VALUES (10, 13);
INSERT INTO groups_privileges VALUES (10, 14);
INSERT INTO groups_privileges VALUES (10, 15);
INSERT INTO groups_privileges VALUES (10, 1);
INSERT INTO groups_privileges VALUES (10, 2);
INSERT INTO groups_privileges VALUES (10, 3);
INSERT INTO groups_privileges VALUES (10, 4);
INSERT INTO groups_privileges VALUES (10, 5);
INSERT INTO groups_privileges VALUES (10, 21);
INSERT INTO groups_privileges VALUES (10, 22);
INSERT INTO groups_privileges VALUES (10, 23);
INSERT INTO groups_privileges VALUES (10, 24);
INSERT INTO groups_privileges VALUES (10, 25);


--
-- Data for Name: privileges; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO privileges VALUES (1, 'PRIVILEGE_LIST', 'Privilege list option', 4, true, '2014-11-11 17:08:31.433482+05:30', '2014-11-11 17:08:31.433482+05:30');
INSERT INTO privileges VALUES (2, 'PRIVILEGE_SHOW', 'Privilege show option', 4, true, '2014-11-11 17:09:04.426064+05:30', '2014-11-11 17:09:04.426064+05:30');
INSERT INTO privileges VALUES (3, 'PRIVILEGE_EDIT', 'Privilege edit option', 4, true, '2014-11-11 17:10:02.904128+05:30', '2014-11-11 17:10:02.904128+05:30');
INSERT INTO privileges VALUES (4, 'PRIVILEGE_DELETE', 'Privilege delete option', 4, true, '2014-11-11 17:10:29.770737+05:30', '2014-11-11 17:10:29.770737+05:30');
INSERT INTO privileges VALUES (5, 'PRIVILEGE_CREATE', 'Privilege create option', 4, true, '2014-11-11 17:11:04.114446+05:30', '2014-11-11 17:11:04.114446+05:30');
INSERT INTO privileges VALUES (6, 'ROLE_LIST', 'Role list option', 2, true, '2014-11-11 17:11:30.727872+05:30', '2014-11-11 17:11:30.727872+05:30');
INSERT INTO privileges VALUES (7, 'ROLE_SHOW', 'Role show option', 2, true, '2014-11-11 17:11:57.416382+05:30', '2014-11-11 17:11:57.416382+05:30');
INSERT INTO privileges VALUES (8, 'ROLE_EDIT', 'Role edit option', 2, true, '2014-11-11 17:12:22.299325+05:30', '2014-11-11 17:12:22.299325+05:30');
INSERT INTO privileges VALUES (9, 'ROLE_DELETE', 'Role delete option', 2, true, '2014-11-11 17:12:47.448338+05:30', '2014-11-11 17:12:47.448338+05:30');
INSERT INTO privileges VALUES (10, 'ROLE_CREATE', 'Role create option', 2, true, '2014-11-11 17:13:09.325597+05:30', '2014-11-11 17:13:09.325597+05:30');
INSERT INTO privileges VALUES (11, 'GROUP_LIST', 'Group list option', 3, true, '2014-11-11 17:14:08.846961+05:30', '2014-11-11 17:14:08.846961+05:30');
INSERT INTO privileges VALUES (12, 'GROUP_SHOW', 'Group show option', 3, true, '2014-11-11 17:14:29.703964+05:30', '2014-11-11 17:14:29.703964+05:30');
INSERT INTO privileges VALUES (13, 'GROUP_EDIT', 'Group edit option', 3, true, '2014-11-11 17:15:21.526963+05:30', '2014-11-11 17:15:21.526963+05:30');
INSERT INTO privileges VALUES (14, 'GROUP_DELETE', 'Group delete option', 3, true, '2014-11-11 17:15:56.670124+05:30', '2014-11-11 17:15:56.670124+05:30');
INSERT INTO privileges VALUES (15, 'GROUP_CREATE', 'Group create option', 3, true, '2014-11-11 17:16:14.066831+05:30', '2014-11-11 17:16:14.066831+05:30');
INSERT INTO privileges VALUES (16, 'USER_LIST', 'User list option', 1, true, '2014-11-11 17:16:47.821685+05:30', '2014-11-11 17:16:47.821685+05:30');
INSERT INTO privileges VALUES (17, 'USER_SHOW', 'User show option', 1, true, '2014-11-11 17:17:13.663861+05:30', '2014-11-11 17:17:13.663861+05:30');
INSERT INTO privileges VALUES (18, 'USER_EDIT', 'User edit option', 1, true, '2014-11-11 17:17:36.829786+05:30', '2014-11-11 17:17:36.829786+05:30');
INSERT INTO privileges VALUES (19, 'USER_DELETE', 'User delete option', 1, true, '2014-11-11 17:18:10.627132+05:30', '2014-11-11 17:18:10.627132+05:30');
INSERT INTO privileges VALUES (20, 'USER_CREATE', 'User create option', 1, true, '2014-11-11 17:18:31.105102+05:30', '2014-11-11 17:18:31.105102+05:30');
INSERT INTO privileges VALUES (21, 'SYSTEM_MODULE_LIST', 'System module list option', 5, true, '2014-11-11 17:18:54.308215+05:30', '2014-11-11 17:18:54.308215+05:30');
INSERT INTO privileges VALUES (22, 'SYSTEM_MODULE_SHOW', 'System module show option', 5, true, '2014-11-11 17:21:20.284319+05:30', '2014-11-11 17:21:20.284319+05:30');
INSERT INTO privileges VALUES (23, 'SYSTEM_MODULE_EDIT', 'System module edit option', 5, true, '2014-11-11 17:21:40.486939+05:30', '2014-11-11 17:21:40.486939+05:30');
INSERT INTO privileges VALUES (24, 'SYSTEM_MODULE_DELETE', 'System module delete option', 5, true, '2014-11-11 17:22:06.993226+05:30', '2014-11-11 17:22:06.993226+05:30');
INSERT INTO privileges VALUES (25, 'SYSTEM_MODULE_CREATE', 'System module create option', 5, true, '2014-11-11 17:22:29.402272+05:30', '2014-11-11 17:22:29.402272+05:30');


--
-- Name: privileges_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('privileges_id_seq', 25, true);


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO roles VALUES (2, 'Main access', 'Main access', true, '2014-11-12 10:25:02.477368+05:30', '2014-11-12 10:25:02.477368+05:30');


--
-- Data for Name: roles_groups; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO roles_groups VALUES (2, 10);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('roles_id_seq', 2, true);


--
-- Data for Name: system_modules; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO system_modules VALUES (1, 'User list', 'User list', 1, true, '2014-11-11 16:26:57.520312+05:30', '2014-11-11 16:26:57.520312+05:30');
INSERT INTO system_modules VALUES (3, 'User groups', 'User groups', 3, true, '2014-11-11 16:27:45.298496+05:30', '2014-11-11 16:27:45.298496+05:30');
INSERT INTO system_modules VALUES (4, 'Privileges', 'Privileges', 4, true, '2014-11-11 16:28:04.682705+05:30', '2014-11-11 16:28:04.682705+05:30');
INSERT INTO system_modules VALUES (5, 'System module', 'System module', 5, true, '2014-11-11 16:28:17.869869+05:30', '2014-11-11 16:28:17.869869+05:30');
INSERT INTO system_modules VALUES (2, 'User roles', 'User roles', 2, true, '2014-11-11 16:27:32.439179+05:30', '2014-11-11 16:30:08.636758+05:30');


--
-- Name: system_modules_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('system_modules_id_seq', 5, true);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO users VALUES (1, 'Tech Schema', 'info@techschema.com', 'e10adc3949ba59abbe56e057f20f883e', 'Male', 9604737557, '2013-01-01', 'Ulhasnagar', 'Superadmin', 2, 'asdas', 'asd', 'asd', 234, true, '2014-11-11 15:28:30.58234+05:30', '2014-11-11 15:28:30.58234+05:30');


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('users_id_seq', 1, true);


--
-- Name: groups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY (id);


--
-- Name: privileges_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY privileges
    ADD CONSTRAINT privileges_pkey PRIMARY KEY (id);


--
-- Name: roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: system_modules_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY system_modules
    ADD CONSTRAINT system_modules_pkey PRIMARY KEY (id);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

