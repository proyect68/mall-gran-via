--
-- PostgreSQL database dump
--

\restrict dTcnSGaowWbKOjeXv3Si5dKtUNyTlpPYeOocHfXi3UlrGVJCuKhOw7Vi6y5AbbU

-- Dumped from database version 18.0
-- Dumped by pg_dump version 18.0

-- Started on 2026-04-21 14:27:03

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 7 (class 2615 OID 67265)
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

-- *not* creating schema, since initdb creates it


ALTER SCHEMA public OWNER TO postgres;

--
-- TOC entry 5300 (class 0 OID 0)
-- Dependencies: 7
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS '';


--
-- TOC entry 3 (class 3079 OID 67737)
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- TOC entry 5302 (class 0 OID 0)
-- Dependencies: 3
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


--
-- TOC entry 2 (class 3079 OID 67266)
-- Name: uuid-ossp; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS "uuid-ossp" WITH SCHEMA public;


--
-- TOC entry 5303 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION "uuid-ossp"; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION "uuid-ossp" IS 'generate universally unique identifiers (UUIDs)';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 221 (class 1259 OID 67277)
-- Name: busquedas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.busquedas (
    id_busqueda integer NOT NULL,
    user_id integer,
    termino_busqueda text,
    fecha timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.busquedas OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 67284)
-- Name: busquedas_id_busqueda_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.busquedas_id_busqueda_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.busquedas_id_busqueda_seq OWNER TO postgres;

--
-- TOC entry 5304 (class 0 OID 0)
-- Dependencies: 222
-- Name: busquedas_id_busqueda_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.busquedas_id_busqueda_seq OWNED BY public.busquedas.id_busqueda;


--
-- TOC entry 259 (class 1259 OID 67821)
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- TOC entry 260 (class 1259 OID 67832)
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 67285)
-- Name: categorias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categorias (
    id_categoria integer NOT NULL,
    nombre character varying(100)
);


ALTER TABLE public.categorias OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 67289)
-- Name: categorias_id_categoria_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categorias_id_categoria_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categorias_id_categoria_seq OWNER TO postgres;

--
-- TOC entry 5305 (class 0 OID 0)
-- Dependencies: 224
-- Name: categorias_id_categoria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categorias_id_categoria_seq OWNED BY public.categorias.id_categoria;


--
-- TOC entry 269 (class 1259 OID 84286)
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    image character varying(255),
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- TOC entry 268 (class 1259 OID 84285)
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO postgres;

--
-- TOC entry 5306 (class 0 OID 0)
-- Dependencies: 268
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- TOC entry 225 (class 1259 OID 67290)
-- Name: colores; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.colores (
    id_color integer NOT NULL,
    nombre character varying(50)
);


ALTER TABLE public.colores OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 67294)
-- Name: colores_id_color_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.colores_id_color_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.colores_id_color_seq OWNER TO postgres;

--
-- TOC entry 5307 (class 0 OID 0)
-- Dependencies: 226
-- Name: colores_id_color_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.colores_id_color_seq OWNED BY public.colores.id_color;


--
-- TOC entry 265 (class 1259 OID 67874)
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- TOC entry 264 (class 1259 OID 67873)
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- TOC entry 5308 (class 0 OID 0)
-- Dependencies: 264
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- TOC entry 227 (class 1259 OID 67295)
-- Name: interacciones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.interacciones (
    id_interaccion integer NOT NULL,
    user_id integer,
    id_producto integer,
    id_tienda integer,
    tipo_interaccion character varying(50),
    fecha timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT check_tipo_interaccion CHECK (((tipo_interaccion)::text = ANY (ARRAY[('click'::character varying)::text, ('vista'::character varying)::text, ('busqueda'::character varying)::text])))
);


ALTER TABLE public.interacciones OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 67301)
-- Name: interacciones_id_interaccion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.interacciones_id_interaccion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.interacciones_id_interaccion_seq OWNER TO postgres;

--
-- TOC entry 5309 (class 0 OID 0)
-- Dependencies: 228
-- Name: interacciones_id_interaccion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.interacciones_id_interaccion_seq OWNED BY public.interacciones.id_interaccion;


--
-- TOC entry 263 (class 1259 OID 67859)
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- TOC entry 262 (class 1259 OID 67844)
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- TOC entry 261 (class 1259 OID 67843)
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- TOC entry 5310 (class 0 OID 0)
-- Dependencies: 261
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- TOC entry 254 (class 1259 OID 67776)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 253 (class 1259 OID 67775)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 5311 (class 0 OID 0)
-- Dependencies: 253
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 229 (class 1259 OID 67302)
-- Name: notificaciones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notificaciones (
    id_notificacion integer NOT NULL,
    titulo character varying(150),
    mensaje text,
    tipo character varying(50),
    fecha timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT check_tipo_notificacion CHECK (((tipo)::text = ANY (ARRAY[('oferta'::character varying)::text, ('sistema'::character varying)::text, ('alerta'::character varying)::text])))
);


ALTER TABLE public.notificaciones OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 67310)
-- Name: notificaciones_id_notificacion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notificaciones_id_notificacion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.notificaciones_id_notificacion_seq OWNER TO postgres;

--
-- TOC entry 5312 (class 0 OID 0)
-- Dependencies: 230
-- Name: notificaciones_id_notificacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notificaciones_id_notificacion_seq OWNED BY public.notificaciones.id_notificacion;


--
-- TOC entry 231 (class 1259 OID 67311)
-- Name: ofertas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ofertas (
    id_oferta integer NOT NULL,
    id_producto integer,
    descuento numeric(5,2),
    fecha_inicio date,
    fecha_fin date,
    tipo_promocion character varying(50),
    CONSTRAINT check_fechas CHECK ((fecha_fin >= fecha_inicio))
);


ALTER TABLE public.ofertas OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 67316)
-- Name: ofertas_id_oferta_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ofertas_id_oferta_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.ofertas_id_oferta_seq OWNER TO postgres;

--
-- TOC entry 5313 (class 0 OID 0)
-- Dependencies: 232
-- Name: ofertas_id_oferta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ofertas_id_oferta_seq OWNED BY public.ofertas.id_oferta;


--
-- TOC entry 257 (class 1259 OID 67800)
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 67317)
-- Name: producto_color; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.producto_color (
    id_producto integer NOT NULL,
    id_color integer NOT NULL
);


ALTER TABLE public.producto_color OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 67322)
-- Name: producto_imagenes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.producto_imagenes (
    id_imagen integer NOT NULL,
    id_producto integer,
    url text
);


ALTER TABLE public.producto_imagenes OWNER TO postgres;

--
-- TOC entry 235 (class 1259 OID 67328)
-- Name: producto_imagenes_id_imagen_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.producto_imagenes_id_imagen_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.producto_imagenes_id_imagen_seq OWNER TO postgres;

--
-- TOC entry 5314 (class 0 OID 0)
-- Dependencies: 235
-- Name: producto_imagenes_id_imagen_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.producto_imagenes_id_imagen_seq OWNED BY public.producto_imagenes.id_imagen;


--
-- TOC entry 236 (class 1259 OID 67329)
-- Name: producto_talla; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.producto_talla (
    id_producto integer NOT NULL,
    id_talla integer NOT NULL
);


ALTER TABLE public.producto_talla OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 67334)
-- Name: productos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.productos (
    id_producto integer NOT NULL,
    id_tienda integer,
    id_subcategoria integer,
    nombre character varying(150) NOT NULL,
    descripcion text,
    precio numeric(10,2) NOT NULL,
    estado character varying(50),
    fecha_creacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    subcategoria_id bigint,
    CONSTRAINT check_estado_producto CHECK (((estado)::text = ANY (ARRAY[('disponible'::character varying)::text, ('agotado'::character varying)::text, ('descontinuado'::character varying)::text]))),
    CONSTRAINT check_precio CHECK ((precio > (0)::numeric))
);


ALTER TABLE public.productos OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 67345)
-- Name: productos_id_producto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.productos_id_producto_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.productos_id_producto_seq OWNER TO postgres;

--
-- TOC entry 5315 (class 0 OID 0)
-- Dependencies: 238
-- Name: productos_id_producto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.productos_id_producto_seq OWNED BY public.productos.id_producto;


--
-- TOC entry 267 (class 1259 OID 67910)
-- Name: products; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.products (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    store character varying(255) NOT NULL,
    price character varying(255) NOT NULL,
    old_price character varying(255),
    offer character varying(255),
    color character varying(255),
    image character varying(255),
    expires character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    is_service boolean DEFAULT false NOT NULL,
    category_id bigint,
    subcategoria_id bigint
);


ALTER TABLE public.products OWNER TO postgres;

--
-- TOC entry 266 (class 1259 OID 67909)
-- Name: products_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.products_id_seq OWNER TO postgres;

--
-- TOC entry 5316 (class 0 OID 0)
-- Dependencies: 266
-- Name: products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.products_id_seq OWNED BY public.products.id;


--
-- TOC entry 239 (class 1259 OID 67346)
-- Name: resenas_producto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.resenas_producto (
    id_resena integer NOT NULL,
    user_id integer,
    id_producto integer,
    calificacion integer,
    comentario text,
    fecha timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT check_calificacion_producto CHECK (((calificacion >= 1) AND (calificacion <= 5))),
    CONSTRAINT resenas_producto_calificacion_check CHECK (((calificacion >= 1) AND (calificacion <= 5)))
);


ALTER TABLE public.resenas_producto OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 67355)
-- Name: resenas_producto_id_resena_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.resenas_producto_id_resena_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.resenas_producto_id_resena_seq OWNER TO postgres;

--
-- TOC entry 5317 (class 0 OID 0)
-- Dependencies: 240
-- Name: resenas_producto_id_resena_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.resenas_producto_id_resena_seq OWNED BY public.resenas_producto.id_resena;


--
-- TOC entry 241 (class 1259 OID 67356)
-- Name: resenas_tienda; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.resenas_tienda (
    id_resena integer NOT NULL,
    user_id integer,
    id_tienda integer,
    calificacion integer,
    comentario text,
    fecha timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT check_calificacion_tienda CHECK (((calificacion >= 1) AND (calificacion <= 5))),
    CONSTRAINT resenas_tienda_calificacion_check CHECK (((calificacion >= 1) AND (calificacion <= 5)))
);


ALTER TABLE public.resenas_tienda OWNER TO postgres;

--
-- TOC entry 242 (class 1259 OID 67365)
-- Name: resenas_tienda_id_resena_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.resenas_tienda_id_resena_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.resenas_tienda_id_resena_seq OWNER TO postgres;

--
-- TOC entry 5318 (class 0 OID 0)
-- Dependencies: 242
-- Name: resenas_tienda_id_resena_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.resenas_tienda_id_resena_seq OWNED BY public.resenas_tienda.id_resena;


--
-- TOC entry 243 (class 1259 OID 67366)
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id_rol integer NOT NULL,
    nombre_rol character varying(50)
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- TOC entry 244 (class 1259 OID 67370)
-- Name: roles_id_rol_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_rol_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_id_rol_seq OWNER TO postgres;

--
-- TOC entry 5319 (class 0 OID 0)
-- Dependencies: 244
-- Name: roles_id_rol_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_rol_seq OWNED BY public.roles.id_rol;


--
-- TOC entry 245 (class 1259 OID 67371)
-- Name: seguidores_tienda; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.seguidores_tienda (
    user_id integer CONSTRAINT seguidores_tienda_id_usuario_not_null NOT NULL,
    id_tienda integer NOT NULL,
    fecha timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.seguidores_tienda OWNER TO postgres;

--
-- TOC entry 258 (class 1259 OID 67809)
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- TOC entry 271 (class 1259 OID 92472)
-- Name: subcategorias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.subcategorias (
    id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    imagen character varying(255),
    descripcion text,
    categoria_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.subcategorias OWNER TO postgres;

--
-- TOC entry 270 (class 1259 OID 92471)
-- Name: subcategorias_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.subcategorias_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.subcategorias_id_seq OWNER TO postgres;

--
-- TOC entry 5320 (class 0 OID 0)
-- Dependencies: 270
-- Name: subcategorias_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.subcategorias_id_seq OWNED BY public.subcategorias.id;


--
-- TOC entry 246 (class 1259 OID 67382)
-- Name: tallas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tallas (
    id_talla integer NOT NULL,
    nombre character varying(20)
);


ALTER TABLE public.tallas OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 67386)
-- Name: tallas_id_talla_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tallas_id_talla_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tallas_id_talla_seq OWNER TO postgres;

--
-- TOC entry 5321 (class 0 OID 0)
-- Dependencies: 247
-- Name: tallas_id_talla_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tallas_id_talla_seq OWNED BY public.tallas.id_talla;


--
-- TOC entry 248 (class 1259 OID 67387)
-- Name: tienda_propietario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tienda_propietario (
    id_tienda integer NOT NULL,
    user_id integer CONSTRAINT tienda_propietario_id_usuario_not_null NOT NULL
);


ALTER TABLE public.tienda_propietario OWNER TO postgres;

--
-- TOC entry 249 (class 1259 OID 67392)
-- Name: tiendas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tiendas (
    id_tienda integer NOT NULL,
    nombre character varying(150) NOT NULL,
    descripcion text,
    banner_url text,
    logo_url text,
    ubicacion character varying(100),
    horario character varying(100),
    estado character varying(50),
    fecha_creacion timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    owner_id integer,
    CONSTRAINT check_estado_tienda CHECK (((estado)::text = ANY (ARRAY[('activa'::character varying)::text, ('inactiva'::character varying)::text, ('suspendida'::character varying)::text])))
);


ALTER TABLE public.tiendas OWNER TO postgres;

--
-- TOC entry 250 (class 1259 OID 67401)
-- Name: tiendas_id_tienda_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tiendas_id_tienda_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tiendas_id_tienda_seq OWNER TO postgres;

--
-- TOC entry 5322 (class 0 OID 0)
-- Dependencies: 250
-- Name: tiendas_id_tienda_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tiendas_id_tienda_seq OWNED BY public.tiendas.id_tienda;


--
-- TOC entry 256 (class 1259 OID 67786)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    role character varying(255) DEFAULT 'cliente'::character varying NOT NULL,
    apellido_paterno character varying(255),
    apellido_materno character varying(255)
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 255 (class 1259 OID 67785)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 5323 (class 0 OID 0)
-- Dependencies: 255
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 251 (class 1259 OID 67402)
-- Name: usuario_notificacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuario_notificacion (
    user_id integer CONSTRAINT usuario_notificacion_id_usuario_not_null NOT NULL,
    id_notificacion integer NOT NULL,
    leido boolean DEFAULT false
);


ALTER TABLE public.usuario_notificacion OWNER TO postgres;

--
-- TOC entry 252 (class 1259 OID 67408)
-- Name: usuario_rol; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuario_rol (
    user_id integer CONSTRAINT usuario_rol_id_usuario_not_null NOT NULL,
    id_rol integer NOT NULL
);


ALTER TABLE public.usuario_rol OWNER TO postgres;

--
-- TOC entry 4943 (class 2604 OID 67424)
-- Name: busquedas id_busqueda; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.busquedas ALTER COLUMN id_busqueda SET DEFAULT nextval('public.busquedas_id_busqueda_seq'::regclass);


--
-- TOC entry 4945 (class 2604 OID 67425)
-- Name: categorias id_categoria; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorias ALTER COLUMN id_categoria SET DEFAULT nextval('public.categorias_id_categoria_seq'::regclass);


--
-- TOC entry 4973 (class 2604 OID 84289)
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- TOC entry 4946 (class 2604 OID 67426)
-- Name: colores id_color; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.colores ALTER COLUMN id_color SET DEFAULT nextval('public.colores_id_color_seq'::regclass);


--
-- TOC entry 4969 (class 2604 OID 67877)
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- TOC entry 4947 (class 2604 OID 67427)
-- Name: interacciones id_interaccion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.interacciones ALTER COLUMN id_interaccion SET DEFAULT nextval('public.interacciones_id_interaccion_seq'::regclass);


--
-- TOC entry 4968 (class 2604 OID 67847)
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- TOC entry 4965 (class 2604 OID 67779)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 4949 (class 2604 OID 67428)
-- Name: notificaciones id_notificacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notificaciones ALTER COLUMN id_notificacion SET DEFAULT nextval('public.notificaciones_id_notificacion_seq'::regclass);


--
-- TOC entry 4951 (class 2604 OID 67429)
-- Name: ofertas id_oferta; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ofertas ALTER COLUMN id_oferta SET DEFAULT nextval('public.ofertas_id_oferta_seq'::regclass);


--
-- TOC entry 4952 (class 2604 OID 67430)
-- Name: producto_imagenes id_imagen; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_imagenes ALTER COLUMN id_imagen SET DEFAULT nextval('public.producto_imagenes_id_imagen_seq'::regclass);


--
-- TOC entry 4953 (class 2604 OID 67431)
-- Name: productos id_producto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos ALTER COLUMN id_producto SET DEFAULT nextval('public.productos_id_producto_seq'::regclass);


--
-- TOC entry 4971 (class 2604 OID 67913)
-- Name: products id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products ALTER COLUMN id SET DEFAULT nextval('public.products_id_seq'::regclass);


--
-- TOC entry 4955 (class 2604 OID 67432)
-- Name: resenas_producto id_resena; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.resenas_producto ALTER COLUMN id_resena SET DEFAULT nextval('public.resenas_producto_id_resena_seq'::regclass);


--
-- TOC entry 4957 (class 2604 OID 67433)
-- Name: resenas_tienda id_resena; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.resenas_tienda ALTER COLUMN id_resena SET DEFAULT nextval('public.resenas_tienda_id_resena_seq'::regclass);


--
-- TOC entry 4959 (class 2604 OID 67434)
-- Name: roles id_rol; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN id_rol SET DEFAULT nextval('public.roles_id_rol_seq'::regclass);


--
-- TOC entry 4974 (class 2604 OID 92475)
-- Name: subcategorias id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subcategorias ALTER COLUMN id SET DEFAULT nextval('public.subcategorias_id_seq'::regclass);


--
-- TOC entry 4961 (class 2604 OID 67436)
-- Name: tallas id_talla; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tallas ALTER COLUMN id_talla SET DEFAULT nextval('public.tallas_id_talla_seq'::regclass);


--
-- TOC entry 4962 (class 2604 OID 67437)
-- Name: tiendas id_tienda; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tiendas ALTER COLUMN id_tienda SET DEFAULT nextval('public.tiendas_id_tienda_seq'::regclass);


--
-- TOC entry 4966 (class 2604 OID 67789)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 5244 (class 0 OID 67277)
-- Dependencies: 221
-- Data for Name: busquedas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.busquedas (id_busqueda, user_id, termino_busqueda, fecha) FROM stdin;
\.


--
-- TOC entry 5282 (class 0 OID 67821)
-- Dependencies: 259
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- TOC entry 5283 (class 0 OID 67832)
-- Dependencies: 260
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- TOC entry 5246 (class 0 OID 67285)
-- Dependencies: 223
-- Data for Name: categorias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categorias (id_categoria, nombre) FROM stdin;
\.


--
-- TOC entry 5292 (class 0 OID 84286)
-- Dependencies: 269
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categories (id, name, image, description, created_at, updated_at) FROM stdin;
1	Moda y accesorios	https://images.unsplash.com/photo-1523293182086-7651a899d37f?w=400&h=300&fit=crop&q=80	Ropa, zapatos, bolsos y accesorios de moda para hombres, mujeres y niños.	2026-04-16 15:34:19	2026-04-16 15:34:19
2	Tecnologia y electronica	https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=400&h=300&fit=crop&q=80	Smartphones, laptops, computadoras, tablets y accesorios tecnológicos.	2026-04-16 15:34:19	2026-04-16 15:34:19
3	Electrodomésticos	https://images.unsplash.com/photo-1584622181563-430f63602d4b?w=400&h=300&fit=crop&q=80	Refrigeradores, lavadoras, microondas y otros electrodomésticos para el hogar.	2026-04-16 15:34:19	2026-04-16 15:34:19
4	Hogar y decoración	https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=400&h=300&fit=crop&q=80	Muebles, cortinas, cuadros, plantas y elementos decorativos para tu hogar.	2026-04-16 15:34:19	2026-04-16 15:34:19
5	Belleza y cuidado personal	https://images.unsplash.com/photo-1596462502278-af242a95ab2b?w=400&h=300&fit=crop&q=80	Cosméticos, perfumes, cuidado de la piel y productos de higiene personal.	2026-04-16 15:34:19	2026-04-16 15:34:19
6	Deportes y entretenimiento	https://images.unsplash.com/photo-1552810519-7a41ec4a3932?w=400&h=300&fit=crop&q=80	Equipos deportivos, videojuegos, juguetes y artículos de entretenimiento.	2026-04-16 15:34:19	2026-04-16 15:34:19
7	Niños y bebés	https://images.unsplash.com/photo-1515488846472-f151bc41816d?w=400&h=300&fit=crop&q=80	Ropa para bebés, juguetes, puericultura y artículos para el cuidado de los niños.	2026-04-16 15:34:19	2026-04-16 15:34:19
8	Comida y restaurantes	https://images.unsplash.com/photo-1495523821757-a1efb6729352?w=400&h=300&fit=crop&q=80	Alimentos, bebidas, comida rápida, restaurantes y servicios de catering.	2026-04-16 15:34:19	2026-04-16 15:34:19
9	Servicios	https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=300&fit=crop&q=80	Servicios diversos: spa, consultoría, asesoramiento y otros servicios profesionales.	2026-04-16 15:34:19	2026-04-16 15:34:19
\.


--
-- TOC entry 5248 (class 0 OID 67290)
-- Dependencies: 225
-- Data for Name: colores; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.colores (id_color, nombre) FROM stdin;
\.


--
-- TOC entry 5288 (class 0 OID 67874)
-- Dependencies: 265
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- TOC entry 5250 (class 0 OID 67295)
-- Dependencies: 227
-- Data for Name: interacciones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.interacciones (id_interaccion, user_id, id_producto, id_tienda, tipo_interaccion, fecha) FROM stdin;
\.


--
-- TOC entry 5286 (class 0 OID 67859)
-- Dependencies: 263
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- TOC entry 5285 (class 0 OID 67844)
-- Dependencies: 262
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- TOC entry 5277 (class 0 OID 67776)
-- Dependencies: 254
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_04_12_000001_add_role_to_users_table	1
6	2026_04_14_000000_create_products_table	2
7	2026_04_16_000000_add_is_service_to_products_table	3
8	2026_04_16_152840_create_categories_table	4
9	2026_04_16_160418_add_category_id_to_products_table	5
11	2026_04_17_141632_create_subcategorias_table	6
12	2026_04_17_141657_add_subcategoria_id_to_productos_table	6
13	2026_04_17_142812_add_subcategoria_id_column_if_not_exists	7
14	2026_04_17_143445_rename_products_table_to_productos	8
15	2026_04_17_152210_add_subcategoria_id_to_products	9
16	2026_04_18_000001_add_fields_to_users_table	10
\.


--
-- TOC entry 5252 (class 0 OID 67302)
-- Dependencies: 229
-- Data for Name: notificaciones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notificaciones (id_notificacion, titulo, mensaje, tipo, fecha) FROM stdin;
\.


--
-- TOC entry 5254 (class 0 OID 67311)
-- Dependencies: 231
-- Data for Name: ofertas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ofertas (id_oferta, id_producto, descuento, fecha_inicio, fecha_fin, tipo_promocion) FROM stdin;
\.


--
-- TOC entry 5280 (class 0 OID 67800)
-- Dependencies: 257
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- TOC entry 5256 (class 0 OID 67317)
-- Dependencies: 233
-- Data for Name: producto_color; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.producto_color (id_producto, id_color) FROM stdin;
\.


--
-- TOC entry 5257 (class 0 OID 67322)
-- Dependencies: 234
-- Data for Name: producto_imagenes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.producto_imagenes (id_imagen, id_producto, url) FROM stdin;
\.


--
-- TOC entry 5259 (class 0 OID 67329)
-- Dependencies: 236
-- Data for Name: producto_talla; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.producto_talla (id_producto, id_talla) FROM stdin;
\.


--
-- TOC entry 5260 (class 0 OID 67334)
-- Dependencies: 237
-- Data for Name: productos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.productos (id_producto, id_tienda, id_subcategoria, nombre, descripcion, precio, estado, fecha_creacion, subcategoria_id) FROM stdin;
\.


--
-- TOC entry 5290 (class 0 OID 67910)
-- Dependencies: 267
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.products (id, name, store, price, old_price, offer, color, image, expires, created_at, updated_at, is_service, category_id, subcategoria_id) FROM stdin;
3	Bolso Urbano	Tienda Plaza	90 BS	120 BS	Especial	offer-purple	https://via.placeholder.com/300x300/8b7355/ffffff?text=Bolso+Urbano	18/04/2026	2026-04-16 16:06:26	2026-04-17 15:46:25	f	1	21
15	Silla Oficina	Hogar Feliz	360 BS	\N	\N	\N	https://via.placeholder.com/300x300/5a4a4a/ffffff?text=Silla+Oficina	\N	2026-04-16 16:06:26	2026-04-18 02:27:44	f	4	4
5	Camisa Casual	Moda Express	80 BS	110 BS	2x1	offer-blue	https://via.placeholder.com/300x300/4d4d4d/ffffff?text=Camisa+Casual	16/04/2026	2026-04-16 16:06:26	2026-04-17 15:46:25	f	1	16
6	Set de Accesorios	Moda Express	60 BS	80 BS	Especial	offer-purple	https://via.placeholder.com/300x300/6b6b6b/ffffff?text=Accesorios	19/04/2026	2026-04-16 16:06:26	2026-04-17 15:46:25	f	1	24
4	Zapatos Trend	Moda Express	150 BS	190 BS	20%	offer-red	https://via.placeholder.com/300x300/2c2c2c/ffffff?text=Zapatos+Trend	14/04/2026	2026-04-16 16:06:26	2026-04-17 16:22:53	f	1	19
9	Smart TV 55"	ElectroMall	2,500 BS	2.941 BS	15%	offer-red	https://via.placeholder.com/300x300/1a1a1a/ffffff?text=Smart+TV	\N	2026-04-16 16:06:26	2026-04-18 02:27:44	f	2	25
17	Yoga Matinal	Studio Wellness	Consultar	\N	15%	offer-red	https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=400&h=300&fit=crop&q=80	30/04/2026	2026-04-17 19:05:14	2026-04-17 19:05:14	t	\N	\N
18	Masaje Terapéutico	Spa Relax	Consultar	\N	20%	offer-red	https://images.unsplash.com/photo-1544161515-81205f8aaea4?w=400&h=300&fit=crop&q=80	28/04/2026	2026-04-17 19:05:14	2026-04-17 20:50:15	t	\N	\N
1	Auriculares Pro	Tienda Plaza	120 BS	180 BS	25%	offer-red	https://via.placeholder.com/300x300/5a5a5a/ffffff?text=Auriculares+Pro	12/04/2026	2026-04-16 16:06:26	2026-04-18 02:27:44	f	2	25
2	Reloj Smart	Tienda Plaza	350 BS	450 BS	2x1	offer-blue	https://via.placeholder.com/300x300/3d3d3d/ffffff?text=Reloj+Smart	15/04/2026	2026-04-16 16:06:26	2026-04-18 02:27:44	f	2	25
8	Combo Sabor Burger	Patio de Comidas	65 BS	\N	2x1	offer-blue	https://via.placeholder.com/300x300/8b6914/ffffff?text=Combo+Burger	22/04/2026	2026-04-16 16:06:26	2026-04-18 02:27:44	t	8	10
10	Cámara deportiva	FotoClick	450 BS	\N	\N	\N	https://via.placeholder.com/300x300/4a4a4a/ffffff?text=Camara+Deportiva	\N	2026-04-16 16:06:26	2026-04-18 02:27:44	f	6	8
11	Perfume Luxury	Beauty Shop	220 BS	\N	Especial	offer-purple	https://via.placeholder.com/300x300/c084a0/ffffff?text=Perfume+Luxury	\N	2026-04-16 16:06:26	2026-04-18 02:27:44	f	5	45
12	Zapatillas Run	Deportes Plus	310 BS	\N	2x1	offer-blue	https://via.placeholder.com/300x300/3a3a3a/ffffff?text=Zapatillas+Run	\N	2026-04-16 16:06:26	2026-04-18 02:27:44	f	6	8
13	Auriculares Gaming	TecnoShop	180 BS	\N	\N	\N	https://via.placeholder.com/300x300/2a2a2a/ffffff?text=Auriculares+Gaming	\N	2026-04-16 16:06:26	2026-04-18 02:27:44	f	2	33
14	Set de maquillaje	Beauty Shop	140 BS	187 BS	25%	offer-red	https://via.placeholder.com/300x300/e0a0d0/ffffff?text=Maquillaje	\N	2026-04-16 16:06:26	2026-04-18 02:27:44	f	5	44
16	Laptop Ultra	ElectroMall	4,200 BS	4.941 BS	15%	offer-red	https://via.placeholder.com/300x300/0a0a0a/ffffff?text=Laptop+Ultra	\N	2026-04-16 16:06:26	2026-04-18 02:27:44	f	2	27
7	Masaje Relajante	Spa & Bienestar	Consultar	\N	25%	offer-red	https://via.placeholder.com/300x300/d4a5a5/ffffff?text=Masaje+Relajante	20/04/2026	2026-04-16 16:06:26	2026-04-18 02:27:44	t	9	11
\.


--
-- TOC entry 5262 (class 0 OID 67346)
-- Dependencies: 239
-- Data for Name: resenas_producto; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.resenas_producto (id_resena, user_id, id_producto, calificacion, comentario, fecha) FROM stdin;
\.


--
-- TOC entry 5264 (class 0 OID 67356)
-- Dependencies: 241
-- Data for Name: resenas_tienda; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.resenas_tienda (id_resena, user_id, id_tienda, calificacion, comentario, fecha) FROM stdin;
\.


--
-- TOC entry 5266 (class 0 OID 67366)
-- Dependencies: 243
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.roles (id_rol, nombre_rol) FROM stdin;
1	cliente
2	comerciante
3	admin
\.


--
-- TOC entry 5268 (class 0 OID 67371)
-- Dependencies: 245
-- Data for Name: seguidores_tienda; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.seguidores_tienda (user_id, id_tienda, fecha) FROM stdin;
\.


--
-- TOC entry 5281 (class 0 OID 67809)
-- Dependencies: 258
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
\.


--
-- TOC entry 5294 (class 0 OID 92472)
-- Dependencies: 271
-- Data for Name: subcategorias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.subcategorias (id, nombre, imagen, descripcion, categoria_id, created_at, updated_at) FROM stdin;
4	Muebles	\N	Muebles para el hogar	4	2026-04-17 14:22:22	2026-04-17 14:22:22
5	Decoración	\N	Artículos decorativos	4	2026-04-17 14:22:22	2026-04-17 14:22:22
6	Cosméticos	\N	Maquillaje y cosmética	5	2026-04-17 14:22:22	2026-04-17 14:22:22
7	Cuidado Personal	\N	Productos de higiene y cuidado	5	2026-04-17 14:22:22	2026-04-17 14:22:22
8	Equipos Deportivos	\N	Equipamiento para deportes	6	2026-04-17 14:22:22	2026-04-17 14:22:22
9	Entretenimiento	\N	Juegos y entretenimiento	6	2026-04-17 14:22:22	2026-04-17 14:22:22
10	Comida Rápida	\N	Comida rápida y delivery	8	2026-04-17 14:22:22	2026-04-17 14:22:22
11	Spa y Bienestar	\N	Servicios de spa y bienestar	9	2026-04-17 14:22:22	2026-04-17 14:22:22
12	Cocina	\N	Electrodomésticos de cocina	3	2026-04-17 14:22:22	2026-04-17 14:22:22
13	Limpieza	\N	Electrodomésticos de limpieza	3	2026-04-17 14:22:22	2026-04-17 14:22:22
15	Juguetes	\N	Juguetes y accesorios	7	2026-04-17 14:22:22	2026-04-17 14:22:22
16	Ropa casual	\N	Prendas cómodas y versátiles para el día a día. Desde camisas hasta poleras, encuentra todo lo que necesitas para estar cómodo.	1	2026-04-17 14:48:21	2026-04-17 16:48:11
17	Ropa formal	\N	Ropa elegante y profesional para ocasiones especiales. Trajes, corbatas y prendas de oficina con estilo.	1	2026-04-17 14:48:21	2026-04-17 16:48:11
18	Ropa deportiva	\N	Atuendos diseñados para el deporte y el fitness. Ropa cómoda y funcional para tus entrenamientos.	1	2026-04-17 14:48:21	2026-04-17 16:48:11
19	Calzado casual	\N	Zapatos cómodos para el día a día. Sneakers, tenis y mocasines con estilo.	1	2026-04-17 14:48:21	2026-04-17 16:48:11
20	Calzado deportivo	\N	Zapatillas diseñadas para correr, entrenar y hacer deporte. Máxima comodidad y soporte.	1	2026-04-17 14:48:21	2026-04-17 16:48:11
21	Bolsos	\N	Mochilas, bolsas y carteras de diversos tamaños. Funcionales y con gran variedad de estilos.	1	2026-04-17 14:48:21	2026-04-17 16:48:11
22	Mochilas	\N	Mochilas prácticas para la escuela, universidad o viajes. Espaciosas y ergonómicas.	1	2026-04-17 14:48:21	2026-04-17 16:48:11
23	Relojes	\N	Relojes elegantes y smartwatches de última tecnología. Perfecto para complementar tu look.	1	2026-04-17 14:48:21	2026-04-17 16:48:11
24	Joyería	\N	Collares, pulseras, anillos y aretes. Accesorios que brillan y realzan tu estilo.	1	2026-04-17 14:48:21	2026-04-17 16:48:11
25	Celulares	\N	Explorar celulares	2	2026-04-18 01:54:10	2026-04-18 01:54:10
26	Tablets	\N	Explorar tablets	2	2026-04-18 01:54:10	2026-04-18 01:54:10
27	Laptops	\N	Explorar laptops	2	2026-04-18 01:54:10	2026-04-18 01:54:10
28	Cargadores	\N	Explorar cargadores	2	2026-04-18 01:54:10	2026-04-18 01:54:10
29	Fundas	\N	Explorar fundas	2	2026-04-18 01:54:10	2026-04-18 01:54:10
30	Audífonos	\N	Explorar audífonos	2	2026-04-18 01:54:10	2026-04-18 01:54:10
31	Parlantes	\N	Explorar parlantes	2	2026-04-18 01:54:10	2026-04-18 01:54:10
32	Televisores	\N	Explorar televisores	2	2026-04-18 01:54:10	2026-04-18 01:54:10
33	Gaming	\N	Explorar gaming	2	2026-04-18 01:54:10	2026-04-18 01:54:10
34	Refrigeradores	\N	Explorar refrigeradores	3	2026-04-18 01:54:10	2026-04-18 01:54:10
35	Lavadoras	\N	Explorar lavadoras	3	2026-04-18 01:54:10	2026-04-18 01:54:10
36	Cocinas	\N	Explorar cocinas	3	2026-04-18 01:54:10	2026-04-18 01:54:10
37	Microondas	\N	Explorar microondas	3	2026-04-18 01:54:10	2026-04-18 01:54:10
38	Licuadoras	\N	Explorar licuadoras	3	2026-04-18 01:54:10	2026-04-18 01:54:10
39	Cafeteras	\N	Explorar cafeteras	3	2026-04-18 01:54:10	2026-04-18 01:54:10
40	Aspiradoras	\N	Explorar aspiradoras	3	2026-04-18 01:54:10	2026-04-18 01:54:10
41	Iluminación	\N	Explorar iluminación	4	2026-04-18 01:54:10	2026-04-18 01:54:10
42	Ropa de cama	\N	Explorar ropa de cama	4	2026-04-18 01:54:10	2026-04-18 01:54:10
43	Organización del hogar	\N	Explorar organización del hogar	4	2026-04-18 01:54:10	2026-04-18 01:54:10
44	Maquillaje	\N	Explorar maquillaje	5	2026-04-18 01:54:10	2026-04-18 01:54:10
45	Perfumes	\N	Explorar perfumes	5	2026-04-18 01:54:10	2026-04-18 01:54:10
46	Cuidado facial	\N	Explorar cuidado facial	5	2026-04-18 01:54:10	2026-04-18 01:54:10
47	Cuidado corporal	\N	Explorar cuidado corporal	5	2026-04-18 01:54:10	2026-04-18 01:54:10
48	Productos capilares	\N	Explorar productos capilares	5	2026-04-18 01:54:10	2026-04-18 01:54:10
49	Barbería	\N	Explorar barbería	5	2026-04-18 01:54:10	2026-04-18 01:54:10
50	Ropa deportiva	\N	Explorar ropa deportiva	6	2026-04-18 01:54:10	2026-04-18 01:54:10
51	Calzado deportivo	\N	Explorar calzado deportivo	6	2026-04-18 01:54:10	2026-04-18 01:54:10
52	Equipamiento fitness	\N	Explorar equipamiento fitness	6	2026-04-18 01:54:10	2026-04-18 01:54:10
53	Bicicletas	\N	Explorar bicicletas	6	2026-04-18 01:54:10	2026-04-18 01:54:10
54	Juegos	\N	Explorar juegos	6	2026-04-18 01:54:10	2026-04-18 01:54:10
55	Ropa infantil	\N	Explorar ropa infantil	7	2026-04-18 01:54:10	2026-04-18 01:54:10
56	Articulos escolares	\N	Explorar articulos escolares	7	2026-04-18 01:54:10	2026-04-18 01:54:10
57	Accesorios para bebé	\N	Explorar accesorios para bebé	7	2026-04-18 01:54:10	2026-04-18 01:54:10
58	Comida rapida	\N	Explorar comida rapida	8	2026-04-18 01:54:10	2026-04-18 01:54:10
59	Restaurantes	\N	Explorar restaurantes	8	2026-04-18 01:54:10	2026-04-18 01:54:10
60	Cafeterias	\N	Explorar cafeterias	8	2026-04-18 01:54:10	2026-04-18 01:54:10
61	Heladerias	\N	Explorar heladerias	8	2026-04-18 01:54:10	2026-04-18 01:54:10
62	Snacks	\N	Explorar snacks	8	2026-04-18 01:54:10	2026-04-18 01:54:10
63	Bebidas	\N	Explorar bebidas	8	2026-04-18 01:54:10	2026-04-18 01:54:10
64	Salones de belleza	\N	Explorar salones de belleza	9	2026-04-18 01:54:10	2026-04-18 01:54:10
65	Gimnasios	\N	Explorar gimnasios	9	2026-04-18 01:54:10	2026-04-18 01:54:10
66	Bancos/cajeros	\N	Explorar bancos/cajeros	9	2026-04-18 01:54:10	2026-04-18 01:54:10
67	Reparaciones	\N	Explorar reparaciones	9	2026-04-18 01:54:10	2026-04-18 01:54:10
68	Otros servicios	\N	Explorar otros servicios	9	2026-04-18 01:54:10	2026-04-18 01:54:10
\.


--
-- TOC entry 5269 (class 0 OID 67382)
-- Dependencies: 246
-- Data for Name: tallas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tallas (id_talla, nombre) FROM stdin;
\.


--
-- TOC entry 5271 (class 0 OID 67387)
-- Dependencies: 248
-- Data for Name: tienda_propietario; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tienda_propietario (id_tienda, user_id) FROM stdin;
\.


--
-- TOC entry 5272 (class 0 OID 67392)
-- Dependencies: 249
-- Data for Name: tiendas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tiendas (id_tienda, nombre, descripcion, banner_url, logo_url, ubicacion, horario, estado, fecha_creacion, owner_id) FROM stdin;
\.


--
-- TOC entry 5279 (class 0 OID 67786)
-- Dependencies: 256
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, role, apellido_paterno, apellido_materno) FROM stdin;
2	Cliente Test	cliente@gmail.com	2026-04-13 14:34:30	$2y$12$Q5zS85s.kCkCGlFu8SI5tOhjhKaiTS1CPUZsuZrtQ3G036cjtySSi	\N	2026-04-13 14:34:30	2026-04-13 14:34:30	cliente	\N	\N
1	Cliente Gonzales Mita	Cliente7806@gmail.com	2026-04-13 14:34:29	$2y$12$UkTwPRsPdksJKOmRHePmge8BB8ujVqXk9Zm/veQfoMUkei329vWjm	\N	2026-04-13 10:11:48	2026-04-13 14:37:17	cliente	\N	\N
3	Cliente Test	cliente@mallgranvia.com	2026-04-15 01:06:01	$2y$12$Np2utVmyk.8UZvao6TQKa.cHYBlpidLm28blUNDDKACOSjGYS2qvK	\N	2026-04-15 01:06:01	2026-04-15 01:06:01	cliente	\N	\N
4	Cliente7208	Cliente7208@gmail.com	2026-04-17 20:49:05	$2y$12$cP/hjLfWhdCA.wTZXKIgte42.pmtod6Xermu3OENa5QNVGSNKWuu6	\N	2026-04-17 20:49:05	2026-04-17 20:49:05	cliente	\N	\N
5	Prueba1	prueba1@gmail.com	\N	$2y$12$zw6pz57aPmeh8YmbzqjJw.5TZA8uIjEO9GOQAMJGhlSnxUaorp/TS	\N	2026-04-18 16:03:45	2026-04-18 16:03:45	user	\N	\N
6	Prueba	Prueba2@gmail.com	\N	$2y$12$DfAeY2zCYwPzIhIIqq6biuPMRAcrbeVpXlN..V7oOiSrc0eDOBNV.	\N	2026-04-18 16:57:00	2026-04-18 16:57:00	user	Tron	Chales
7	Cliente0782	Cliente0782@gmail.com	2026-04-19 18:23:06	$2y$12$4zzS1uKtfcnda7rsMRsBueJeJ3f/cKqhsrnGdQl.JnQFmToFcJSLS	\N	2026-04-19 18:23:06	2026-04-19 18:23:06	cliente	\N	\N
8	Juan	Juan2@gmail.com	\N	$2y$12$rxLTTfL53PirAPnPwFlp6uIl5SJmrkcmKJfv8g/Phaxjaffxee6hO	\N	2026-04-19 21:17:45	2026-04-19 21:17:45	user	Mamani	Montes
9	Cliente786	Cliente786@gmail.com	2026-04-19 21:18:32	$2y$12$frUgZaLqaaP.nkte7W1D3.VIk5Um6e966iDyWEVXDbd3LDekUtMw.	\N	2026-04-19 21:18:32	2026-04-19 21:18:32	cliente	\N	\N
10	Pepe	Pepito678@gmail.com	\N	$2y$12$dXqW44/IRydhGFvGsNk3Te9/ZL8iT/xjZ2lUIVheoNpNxJ1tNo8/G	\N	2026-04-19 21:30:27	2026-04-19 21:30:27	user	Mamani	Montes
\.


--
-- TOC entry 5274 (class 0 OID 67402)
-- Dependencies: 251
-- Data for Name: usuario_notificacion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuario_notificacion (user_id, id_notificacion, leido) FROM stdin;
\.


--
-- TOC entry 5275 (class 0 OID 67408)
-- Dependencies: 252
-- Data for Name: usuario_rol; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuario_rol (user_id, id_rol) FROM stdin;
1	1
\.


--
-- TOC entry 5324 (class 0 OID 0)
-- Dependencies: 222
-- Name: busquedas_id_busqueda_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.busquedas_id_busqueda_seq', 1, false);


--
-- TOC entry 5325 (class 0 OID 0)
-- Dependencies: 224
-- Name: categorias_id_categoria_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categorias_id_categoria_seq', 1, false);


--
-- TOC entry 5326 (class 0 OID 0)
-- Dependencies: 268
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_id_seq', 9, true);


--
-- TOC entry 5327 (class 0 OID 0)
-- Dependencies: 226
-- Name: colores_id_color_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.colores_id_color_seq', 1, false);


--
-- TOC entry 5328 (class 0 OID 0)
-- Dependencies: 264
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- TOC entry 5329 (class 0 OID 0)
-- Dependencies: 228
-- Name: interacciones_id_interaccion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.interacciones_id_interaccion_seq', 1, false);


--
-- TOC entry 5330 (class 0 OID 0)
-- Dependencies: 261
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- TOC entry 5331 (class 0 OID 0)
-- Dependencies: 253
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 16, true);


--
-- TOC entry 5332 (class 0 OID 0)
-- Dependencies: 230
-- Name: notificaciones_id_notificacion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notificaciones_id_notificacion_seq', 1, false);


--
-- TOC entry 5333 (class 0 OID 0)
-- Dependencies: 232
-- Name: ofertas_id_oferta_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ofertas_id_oferta_seq', 1, false);


--
-- TOC entry 5334 (class 0 OID 0)
-- Dependencies: 235
-- Name: producto_imagenes_id_imagen_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.producto_imagenes_id_imagen_seq', 1, false);


--
-- TOC entry 5335 (class 0 OID 0)
-- Dependencies: 238
-- Name: productos_id_producto_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.productos_id_producto_seq', 1, false);


--
-- TOC entry 5336 (class 0 OID 0)
-- Dependencies: 266
-- Name: products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.products_id_seq', 18, true);


--
-- TOC entry 5337 (class 0 OID 0)
-- Dependencies: 240
-- Name: resenas_producto_id_resena_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.resenas_producto_id_resena_seq', 1, false);


--
-- TOC entry 5338 (class 0 OID 0)
-- Dependencies: 242
-- Name: resenas_tienda_id_resena_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.resenas_tienda_id_resena_seq', 1, false);


--
-- TOC entry 5339 (class 0 OID 0)
-- Dependencies: 244
-- Name: roles_id_rol_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_rol_seq', 3, true);


--
-- TOC entry 5340 (class 0 OID 0)
-- Dependencies: 270
-- Name: subcategorias_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.subcategorias_id_seq', 68, true);


--
-- TOC entry 5341 (class 0 OID 0)
-- Dependencies: 247
-- Name: tallas_id_talla_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tallas_id_talla_seq', 1, false);


--
-- TOC entry 5342 (class 0 OID 0)
-- Dependencies: 250
-- Name: tiendas_id_tienda_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tiendas_id_tienda_seq', 1, false);


--
-- TOC entry 5343 (class 0 OID 0)
-- Dependencies: 255
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 10, true);


--
-- TOC entry 4986 (class 2606 OID 67440)
-- Name: busquedas busquedas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.busquedas
    ADD CONSTRAINT busquedas_pkey PRIMARY KEY (id_busqueda);


--
-- TOC entry 5046 (class 2606 OID 67841)
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- TOC entry 5043 (class 2606 OID 67830)
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- TOC entry 4988 (class 2606 OID 67442)
-- Name: categorias categorias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT categorias_pkey PRIMARY KEY (id_categoria);


--
-- TOC entry 5059 (class 2606 OID 84297)
-- Name: categories categories_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_name_unique UNIQUE (name);


--
-- TOC entry 5061 (class 2606 OID 84295)
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- TOC entry 4990 (class 2606 OID 67444)
-- Name: colores colores_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.colores
    ADD CONSTRAINT colores_pkey PRIMARY KEY (id_color);


--
-- TOC entry 5053 (class 2606 OID 67889)
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 5055 (class 2606 OID 67891)
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- TOC entry 4992 (class 2606 OID 67446)
-- Name: interacciones interacciones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.interacciones
    ADD CONSTRAINT interacciones_pkey PRIMARY KEY (id_interaccion);


--
-- TOC entry 5051 (class 2606 OID 67872)
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- TOC entry 5048 (class 2606 OID 67857)
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 5030 (class 2606 OID 67784)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 4994 (class 2606 OID 67448)
-- Name: notificaciones notificaciones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notificaciones
    ADD CONSTRAINT notificaciones_pkey PRIMARY KEY (id_notificacion);


--
-- TOC entry 4996 (class 2606 OID 67450)
-- Name: ofertas ofertas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ofertas
    ADD CONSTRAINT ofertas_pkey PRIMARY KEY (id_oferta);


--
-- TOC entry 5036 (class 2606 OID 67808)
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- TOC entry 4998 (class 2606 OID 67452)
-- Name: producto_color producto_color_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_color
    ADD CONSTRAINT producto_color_pkey PRIMARY KEY (id_producto, id_color);


--
-- TOC entry 5000 (class 2606 OID 67454)
-- Name: producto_imagenes producto_imagenes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_imagenes
    ADD CONSTRAINT producto_imagenes_pkey PRIMARY KEY (id_imagen);


--
-- TOC entry 5002 (class 2606 OID 67456)
-- Name: producto_talla producto_talla_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_talla
    ADD CONSTRAINT producto_talla_pkey PRIMARY KEY (id_producto, id_talla);


--
-- TOC entry 5004 (class 2606 OID 67458)
-- Name: productos productos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_pkey PRIMARY KEY (id_producto);


--
-- TOC entry 5057 (class 2606 OID 67921)
-- Name: products products_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (id);


--
-- TOC entry 5006 (class 2606 OID 67460)
-- Name: resenas_producto resenas_producto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.resenas_producto
    ADD CONSTRAINT resenas_producto_pkey PRIMARY KEY (id_resena);


--
-- TOC entry 5010 (class 2606 OID 67462)
-- Name: resenas_tienda resenas_tienda_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.resenas_tienda
    ADD CONSTRAINT resenas_tienda_pkey PRIMARY KEY (id_resena);


--
-- TOC entry 5012 (class 2606 OID 67464)
-- Name: roles roles_nombre_rol_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_nombre_rol_key UNIQUE (nombre_rol);


--
-- TOC entry 5014 (class 2606 OID 67466)
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id_rol);


--
-- TOC entry 5016 (class 2606 OID 67468)
-- Name: seguidores_tienda seguidores_tienda_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seguidores_tienda
    ADD CONSTRAINT seguidores_tienda_pkey PRIMARY KEY (user_id, id_tienda);


--
-- TOC entry 5039 (class 2606 OID 67818)
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- TOC entry 5063 (class 2606 OID 92482)
-- Name: subcategorias subcategorias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subcategorias
    ADD CONSTRAINT subcategorias_pkey PRIMARY KEY (id);


--
-- TOC entry 5020 (class 2606 OID 67472)
-- Name: tallas tallas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tallas
    ADD CONSTRAINT tallas_pkey PRIMARY KEY (id_talla);


--
-- TOC entry 5022 (class 2606 OID 67474)
-- Name: tienda_propietario tienda_propietario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tienda_propietario
    ADD CONSTRAINT tienda_propietario_pkey PRIMARY KEY (id_tienda, user_id);


--
-- TOC entry 5024 (class 2606 OID 67476)
-- Name: tiendas tiendas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tiendas
    ADD CONSTRAINT tiendas_pkey PRIMARY KEY (id_tienda);


--
-- TOC entry 5008 (class 2606 OID 67480)
-- Name: resenas_producto unique_resena_usuario_producto; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.resenas_producto
    ADD CONSTRAINT unique_resena_usuario_producto UNIQUE (user_id, id_producto);


--
-- TOC entry 5018 (class 2606 OID 67482)
-- Name: seguidores_tienda unique_seguidor; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seguidores_tienda
    ADD CONSTRAINT unique_seguidor UNIQUE (user_id, id_tienda);


--
-- TOC entry 5032 (class 2606 OID 67799)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 5034 (class 2606 OID 67797)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 5026 (class 2606 OID 67484)
-- Name: usuario_notificacion usuario_notificacion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario_notificacion
    ADD CONSTRAINT usuario_notificacion_pkey PRIMARY KEY (user_id, id_notificacion);


--
-- TOC entry 5028 (class 2606 OID 67486)
-- Name: usuario_rol usuario_rol_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario_rol
    ADD CONSTRAINT usuario_rol_pkey PRIMARY KEY (user_id, id_rol);


--
-- TOC entry 5041 (class 1259 OID 67831)
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- TOC entry 5044 (class 1259 OID 67842)
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- TOC entry 5049 (class 1259 OID 67858)
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- TOC entry 5037 (class 1259 OID 67820)
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- TOC entry 5040 (class 1259 OID 67819)
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- TOC entry 5064 (class 2606 OID 67501)
-- Name: interacciones fk_interaccion_producto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.interacciones
    ADD CONSTRAINT fk_interaccion_producto FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto);


--
-- TOC entry 5065 (class 2606 OID 67506)
-- Name: interacciones fk_interaccion_tienda; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.interacciones
    ADD CONSTRAINT fk_interaccion_tienda FOREIGN KEY (id_tienda) REFERENCES public.tiendas(id_tienda);


--
-- TOC entry 5068 (class 2606 OID 67516)
-- Name: ofertas fk_oferta_producto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ofertas
    ADD CONSTRAINT fk_oferta_producto FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto) ON DELETE CASCADE;


--
-- TOC entry 5070 (class 2606 OID 67521)
-- Name: producto_color fk_producto_color_color; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_color
    ADD CONSTRAINT fk_producto_color_color FOREIGN KEY (id_color) REFERENCES public.colores(id_color);


--
-- TOC entry 5071 (class 2606 OID 67526)
-- Name: producto_color fk_producto_color_producto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_color
    ADD CONSTRAINT fk_producto_color_producto FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto) ON DELETE CASCADE;


--
-- TOC entry 5074 (class 2606 OID 67531)
-- Name: producto_imagenes fk_producto_imagen; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_imagenes
    ADD CONSTRAINT fk_producto_imagen FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto) ON DELETE CASCADE;


--
-- TOC entry 5076 (class 2606 OID 67541)
-- Name: producto_talla fk_producto_talla_producto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_talla
    ADD CONSTRAINT fk_producto_talla_producto FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto) ON DELETE CASCADE;


--
-- TOC entry 5077 (class 2606 OID 67546)
-- Name: producto_talla fk_producto_talla_talla; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_talla
    ADD CONSTRAINT fk_producto_talla_talla FOREIGN KEY (id_talla) REFERENCES public.tallas(id_talla);


--
-- TOC entry 5080 (class 2606 OID 67551)
-- Name: productos fk_producto_tienda; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT fk_producto_tienda FOREIGN KEY (id_tienda) REFERENCES public.tiendas(id_tienda);


--
-- TOC entry 5083 (class 2606 OID 67561)
-- Name: resenas_producto fk_resena_producto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.resenas_producto
    ADD CONSTRAINT fk_resena_producto FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto);


--
-- TOC entry 5086 (class 2606 OID 67571)
-- Name: seguidores_tienda fk_seguidor_tienda; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seguidores_tienda
    ADD CONSTRAINT fk_seguidor_tienda FOREIGN KEY (id_tienda) REFERENCES public.tiendas(id_tienda);


--
-- TOC entry 5088 (class 2606 OID 67586)
-- Name: tienda_propietario fk_tienda_propietario_tienda; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tienda_propietario
    ADD CONSTRAINT fk_tienda_propietario_tienda FOREIGN KEY (id_tienda) REFERENCES public.tiendas(id_tienda) ON DELETE CASCADE;


--
-- TOC entry 5090 (class 2606 OID 67596)
-- Name: usuario_notificacion fk_usuario_notif_notificacion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario_notificacion
    ADD CONSTRAINT fk_usuario_notif_notificacion FOREIGN KEY (id_notificacion) REFERENCES public.notificaciones(id_notificacion) ON DELETE CASCADE;


--
-- TOC entry 5092 (class 2606 OID 67606)
-- Name: usuario_rol fk_usuario_rol_rol; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario_rol
    ADD CONSTRAINT fk_usuario_rol_rol FOREIGN KEY (id_rol) REFERENCES public.roles(id_rol) ON DELETE CASCADE;


--
-- TOC entry 5066 (class 2606 OID 67616)
-- Name: interacciones interacciones_id_producto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.interacciones
    ADD CONSTRAINT interacciones_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto);


--
-- TOC entry 5067 (class 2606 OID 67621)
-- Name: interacciones interacciones_id_tienda_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.interacciones
    ADD CONSTRAINT interacciones_id_tienda_fkey FOREIGN KEY (id_tienda) REFERENCES public.tiendas(id_tienda);


--
-- TOC entry 5069 (class 2606 OID 67631)
-- Name: ofertas ofertas_id_producto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ofertas
    ADD CONSTRAINT ofertas_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto) ON DELETE CASCADE;


--
-- TOC entry 5072 (class 2606 OID 67636)
-- Name: producto_color producto_color_id_color_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_color
    ADD CONSTRAINT producto_color_id_color_fkey FOREIGN KEY (id_color) REFERENCES public.colores(id_color);


--
-- TOC entry 5073 (class 2606 OID 67641)
-- Name: producto_color producto_color_id_producto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_color
    ADD CONSTRAINT producto_color_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto) ON DELETE CASCADE;


--
-- TOC entry 5075 (class 2606 OID 67646)
-- Name: producto_imagenes producto_imagenes_id_producto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_imagenes
    ADD CONSTRAINT producto_imagenes_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto) ON DELETE CASCADE;


--
-- TOC entry 5078 (class 2606 OID 67651)
-- Name: producto_talla producto_talla_id_producto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_talla
    ADD CONSTRAINT producto_talla_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto) ON DELETE CASCADE;


--
-- TOC entry 5079 (class 2606 OID 67656)
-- Name: producto_talla producto_talla_id_talla_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_talla
    ADD CONSTRAINT producto_talla_id_talla_fkey FOREIGN KEY (id_talla) REFERENCES public.tallas(id_talla);


--
-- TOC entry 5081 (class 2606 OID 67666)
-- Name: productos productos_id_tienda_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_id_tienda_fkey FOREIGN KEY (id_tienda) REFERENCES public.tiendas(id_tienda) ON DELETE CASCADE;


--
-- TOC entry 5082 (class 2606 OID 92488)
-- Name: productos productos_subcategoria_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_subcategoria_id_foreign FOREIGN KEY (subcategoria_id) REFERENCES public.subcategorias(id) ON DELETE SET NULL;


--
-- TOC entry 5094 (class 2606 OID 84298)
-- Name: products products_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE SET NULL;


--
-- TOC entry 5095 (class 2606 OID 92493)
-- Name: products products_subcategoria_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_subcategoria_id_foreign FOREIGN KEY (subcategoria_id) REFERENCES public.subcategorias(id) ON DELETE SET NULL;


--
-- TOC entry 5084 (class 2606 OID 67671)
-- Name: resenas_producto resenas_producto_id_producto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.resenas_producto
    ADD CONSTRAINT resenas_producto_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto) ON DELETE CASCADE;


--
-- TOC entry 5085 (class 2606 OID 67681)
-- Name: resenas_tienda resenas_tienda_id_tienda_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.resenas_tienda
    ADD CONSTRAINT resenas_tienda_id_tienda_fkey FOREIGN KEY (id_tienda) REFERENCES public.tiendas(id_tienda) ON DELETE CASCADE;


--
-- TOC entry 5087 (class 2606 OID 67691)
-- Name: seguidores_tienda seguidores_tienda_id_tienda_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seguidores_tienda
    ADD CONSTRAINT seguidores_tienda_id_tienda_fkey FOREIGN KEY (id_tienda) REFERENCES public.tiendas(id_tienda) ON DELETE CASCADE;


--
-- TOC entry 5096 (class 2606 OID 92483)
-- Name: subcategorias subcategorias_categoria_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subcategorias
    ADD CONSTRAINT subcategorias_categoria_id_foreign FOREIGN KEY (categoria_id) REFERENCES public.categories(id) ON DELETE CASCADE;


--
-- TOC entry 5089 (class 2606 OID 67706)
-- Name: tienda_propietario tienda_propietario_id_tienda_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tienda_propietario
    ADD CONSTRAINT tienda_propietario_id_tienda_fkey FOREIGN KEY (id_tienda) REFERENCES public.tiendas(id_tienda) ON DELETE CASCADE;


--
-- TOC entry 5091 (class 2606 OID 67716)
-- Name: usuario_notificacion usuario_notificacion_id_notificacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario_notificacion
    ADD CONSTRAINT usuario_notificacion_id_notificacion_fkey FOREIGN KEY (id_notificacion) REFERENCES public.notificaciones(id_notificacion) ON DELETE CASCADE;


--
-- TOC entry 5093 (class 2606 OID 67726)
-- Name: usuario_rol usuario_rol_id_rol_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario_rol
    ADD CONSTRAINT usuario_rol_id_rol_fkey FOREIGN KEY (id_rol) REFERENCES public.roles(id_rol) ON DELETE CASCADE;


--
-- TOC entry 5301 (class 0 OID 0)
-- Dependencies: 7
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE USAGE ON SCHEMA public FROM PUBLIC;


-- Completed on 2026-04-21 14:27:03

--
-- PostgreSQL database dump complete
--

\unrestrict dTcnSGaowWbKOjeXv3Si5dKtUNyTlpPYeOocHfXi3UlrGVJCuKhOw7Vi6y5AbbU

