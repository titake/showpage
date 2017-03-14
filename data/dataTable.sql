CREATE DATEBASE IF NOT EXISTS 'titake';
USE 'titake';

-- 管理员表
DROP TABLE IF EXISTS 'tb_adminiter';
CREATE TABLE 'tb_adminiter'(
	'idcard_num' char(18) not null unique key COMMENT '身份证号',
	'username' char(20) not null COMMENT '姓名',
	'phonenum' char(11) not null COMMENT '电话号码',
	'email' char(30) not null COMMENT '邮箱',
	'institution' varchar(100) not null COMMENT '工作单位'
)COMMENT '管理员表';

--驾驶员表
DROP TABLE IF EXISTS 'tb_driver';
CREATE TABLE 'tb_driver'(
	'idcard_num' char(18) primary key COMMENT '身份证号',
	'username' char(20) not null COMMENT '姓名',
	'sex' enum('男','女') not null COMMENT '性别',
	'driveLicence_id' char(20) not null unique key COMMENT '驾驶证号',
	'driverLicence_num' char(14) not null unique key COMMENT '档案编号',
	'date_getLice' int unsigned not null COMMENT '初领证时间',
	'cars_permi' set('A1','A2','A3','B1','B2','C1','C2','C3','E') not null COMMENT '准驾车型',
	'job_permi_id' char(20) not null unique key COMMENT '从业资格证号',
	'job_permi_date' date not null COMMENT '从业资格证到期时间',
	'phone_num' char(11)	not null COMMENT '电话',
	'address' varchar(255) not null COMMENT '通讯地址',
	'picture' varchar(255) not null COMMENT '图片',
	'ifblock' tinyint not null default 0 COMMENT '是否黑名单',
	'star_polite' tinyint unsigned default 1 COMMENT '文明星',
	'star_safe' tinyint unsigned default 1 COMMENT '安全星',
	'star_law' tinyint unsigned default 1 COMMENT '守法星',
	'star_honest' tinyint unsigned default 1 COMMENT '诚信星',
	'star_server' tinyint unsigned default 1 COMMENT '服务星'
)COMMENT '驾驶员表';

--出租客运车表
DROP TABLE IF EXISTS 'tb_taxi';
CREATE TABLE 'tb_taxi'(
	'plate_num' char(10) primary key COMMENT '车牌号',
	'car_classify' char(24) not null COMMENT '车辆类型',
	'car_brand' char(50) not null COMMENT '品牌与型号',
	'comp_name' varchar(100) not null COMMENT '所属企业',
	'engine_num' char(16) not null COMMENT '发动机号',
	'vin' char(18) not null unique key COMMENT '车辆识别号',
	'people_num' tinyint unsigned not null COMMENT '核载人数',
	'date_registe' int unsigned not null COMMENT '注册日期',
	'date_getLicence' int unsigned not null COMMENT '发证日期',
	'date_verify' int unsigned not null COMMENT '年审日期',
	'date_valid' int unsigned not null COMMENT '检验有效期',
	'img' varchar(255) not null COMMENT'车辆照片',
	'operate_num' char(30) COMMENT '运营证号',
	'file_num' char(25) not null COMMENT '档案编号',
	'date_opera_valid' date not null COMMENT '经营有效期'
)COMMENT '出租客运车表';

--公交车表
DROP TABLE IF EXISTS 'tb_bus';
CREATE TABLE 'tb_bus'(
	'plate_num' char(10) primary key COMMENT '车牌号',
	'car_classify' char(24) not null COMMENT '车辆类型',
	'car_brand' char(50) not null COMMENT '品牌与型号',
	'comp_name' varchar(100) not null COMMENT '所属企业',
	'engine_num' char(16) not null COMMENT '发动机号',
	'vin' char(18) not null unique key COMMENT '车辆识别号',
	'people_num' tinyint unsigned not null COMMENT '核载人数',
	'date_registe' int unsigned not null COMMENT '注册日期',
	'date_getLicence' int unsigned not null COMMENT '发证日期',
	'date_verify' int unsigned not null COMMENT '年审日期',
	'date_valid' int unsigned not null COMMENT '检验有效期',
	'file_num' char(25) not null COMMENT '档案编号',
	'img' varchar(255) not null COMMENT'车辆照片',
	'operate_num' char(30) COMMENT '运营证号',
	'operate_line' text not null COMMENT '运营线路',
	'operate_mileage' float[(4,1)] not null COMMENT '运营里程'
)COMMENT '公交车表';

--班车表
DROP TABLE IF EXISTS 'tb_shuttle';
CREATE TABLE 'tb_shuttle'(
	'plate_num' char(10) primary key COMMENT '车牌号',
	'car_classify' char(24) not null COMMENT '车辆类型',
	'car_brand' char(50) not null COMMENT '品牌与型号',
	'comp_name' varchar(100) not null COMMENT '所属企业',
	'engine_num' char(16) not null COMMENT '发动机号',
	'vin' char(18) not null unique key COMMENT '车辆识别号',
	'people_num' tinyint unsigned not null COMMENT '核载人数',
	'date_registe' int unsigned not null COMMENT '注册日期',
	'date_getLicence' int unsigned not null COMMENT '发证日期',
	'date_verify' int unsigned not null COMMENT '年审日期',
	'date_valid' int unsigned not null COMMENT '检验有效期',
	'file_num' char(25) not null COMMENT '档案编号',
	'img' varchar(255) not null COMMENT'车辆照片',
	'operate_num' char(30) COMMENT '运营证号',
	'operate_line' text not null COMMENT '运营线路',
	'operate_mileage' float[(4,1)] not null COMMENT '运营里程',
	'operate_valid_date' date not null COMMENT '线路牌有效期'
)COMMENT '班车表';

--普通货车表
DROP TABLE IF EXISTS 'tb_normal_truck';
CREATE TABLE 'tb_normal_truck'(
	'plate_num' char(10) primary key COMMENT '车牌号',
	'car_classify' char(24) not null COMMENT '车辆类型',
	'car_brand' char(50) not null COMMENT '品牌与型号',
	'comp_name' varchar(100) not null COMMENT '所属企业',
	'engine_num' char(16) not null COMMENT '发动机号',
	'vin' char(18) not null unique key COMMENT '车辆识别号',
	'people_num' tinyint unsigned not null COMMENT '核载人数',
	'date_registe' int unsigned not null COMMENT '注册日期',
	'date_getLicence' int unsigned not null COMMENT '发证日期',
	'date_verify' int unsigned not null COMMENT '年审日期',
	'date_valid' int unsigned not null COMMENT '检验有效期',
	'file_num' char(25) not null COMMENT '档案编号',
	'img' varchar(255) not null COMMENT'车辆照片',
	'operate_num' char(30) COMMENT '运营证号'
)COMMENT '普通货车表';

--危险品货车表
DROP TABLE IF EXISTS 'tb_danger_truck';
CREATE TABLE 'tb_danger_truck'(
	'plate_num' char(10) primary key COMMENT '车牌号',
	'car_brand' char(50) not null COMMENT '汽车品牌与型号',
	'comp_name' varchar(100) not null COMMENT '所属企业',
	'engine_num' char(16) not null COMMENT '发动机号',
	'vin' char(18) not null unique key COMMENT '车辆识别号',
	'people_num' tinyint unsigned not null COMMENT '核载人数',
	'date_registe' int unsigned not null COMMENT '注册日期',
	'date_getLicence' int unsigned not null COMMENT '发证日期',
	'date_verify' int unsigned not null COMMENT '年审日期',
	'date_valid' int unsigned not null COMMENT '检验有效期',
	'img' varchar(255) not null COMMENT'车辆照片',
	'operate_num' char(30) not null COMMENT '运营证号',
	'danger_name' char(30) not null COMMENT '危险品名称',
	'car_classify' char(24) not null COMMENT '车辆类型'
)COMMENT '普通货车表';

--教练车表
DROP TABLE IF EXISTS 'tb_student_car';
CREATE TABLE 'tb_student_car'(
	'plate_num' char(10) primary key COMMENT '车牌号',
	'car_classify' char(24) not null COMMENT '车辆类型',
	'car_brand' char(50) not null COMMENT '品牌与型号',
	'comp_name' varchar(100) not null COMMENT '所属企业',
	'engine_num' char(16) not null COMMENT '发动机号',
	'vin' char(18) not null unique key COMMENT '车辆识别号',
	'people_num' tinyint unsigned not null COMMENT '核载人数',
	'date_registe' int unsigned not null COMMENT '注册日期',
	'date_getLicence' int unsigned not null COMMENT '发证日期',
	'date_verify' int unsigned not null COMMENT '年审日期',
	'date_valid' int unsigned not null COMMENT '检验有效期',
	'img' varchar(255) not null COMMENT'车辆照片',
	'operate_num' char(30) not null COMMENT '运营证号'
)COMMENT '教练车表';

--保险单表
DROP TABLE IF EXISTS 'tb_insurance';
CREATE TABLE 'tb_insurance'(
	'plate_num' char(10) not null primary key COMMENT '车牌号',
	'impunity_num' char(30) not null COMMENT '交强险单号',
	'impunity_date' date not null COMMENT '交强险到期时间',
	'commercial_num' char(30) not null COMMENT '商业险单号',
	'commercial_date' date not null COMMENT '商业险到期时间',
	'liability_num' char(30) not null COMMENT '交强险单号',
	'liability_date' date not null COMMENT '交强险到期时间',
	'insur_comp_name' varchar(100) not null COMMENT '投保公司',
	'comp_phone' char(11) not null COMMENT '保险公司联系方式'
)COMMENT '保险单表';

--维修公司表
DROP TABLE IF EXISTS 'tb_maincomp';
CREATE TABLE 'tb_maincomp'(
	'name' varchar(100) not null primary key COMMENT '企业名称',
	'registe_money' float[(6,1)] not null COMMENT '注册金额',
	'registe_address' varchar(255) not null COMMENT '注册地址',
	'registe_date' int unsigned not null COMMENT '注册日期',
	'registe_valid_date' int unsigned not null COMMENT '有效日期',
	'staff_num' mediumint unsigned not null COMMENT '员工人数',
	'corporation' char(20) not null COMMENT '法人姓名',
	'corporation_phone' char(11) not null COMMENT '联系方式',
	'charge_person' char(20) not null COMMENT '主要负责人姓名',
	'charge_phone' char(11) not null COMMENT '主要负责人联系方式',
	'scope' tinytext not null COMMENT '主要经营范围',
	'qualification' tinytext not null COMMENT '有效资质',
	'main_classify' ENUM('1','2') not null COMMENT '维护级别'
) COMMENT '维修公司';

--车辆二级维护工作表
DROP TABLE IF EXISTS 'tb_maintenance_level2';
CREATE TABLE 'tb_maintenance_level2'(
	'plate_num' char(10) primary key COMMENT '车牌号',
	'maint_date' int unsinged not null COMMENT '时间',
	'project_maint' varchar(80) not null COMMENT '维修项目',
	'unit_repair' varchar(100) not null COMMENT '维修部件',
	'maint_address' varchar(255) not null COMMENT '维修地点',
	'maint_comp' varchar(100) not null COMMENT '维修企业'
) COMMENT '车辆二级维护工作表';