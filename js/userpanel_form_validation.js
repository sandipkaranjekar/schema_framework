$(document).ready(function(){
	 $.validator.addMethod(
	     "DateFormat",
	     function(value, element) {
	     return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
	     },
	      "Please enter a date in the format mm/dd/yyyy"//removed ;
	  );
	
	$("#frm_registration").validate({
		rules: {
				name: "required",
				email: {
					required: true,
					email: true
				},
				contact: {
					required: true,
					number: true
				},
				dob: {
					required: true,
					DateFormat : true
				},
				address: "required",
				upload_photo: "required",
				designation: "required",
				role: "required",
			},

		messages: {
				name: "Please enter the name.",
				email: {
					required: "Please enter the email address.",
					email: "Please enter the valid email address."
				},
				contact: {
					required: "Please enter the contact number.",
					number: "Please enter the numbers only."
				},
				dob: {
					required: "Please enter the date of birth.",
				},
				address: "Please enter the address.",
				upload_photo: "Please select the photo.",
				designation: "Please select the designation.",
				role: "Please select the role.",
			}
	});

	// User role validation
	$("#frm_role").validate({
		rules: {
				roles_name: "required",
				role_descrip: "required",
				cb_role_name: "required",
				role_active: "required",
			},

		messages: {
			roles_name: "Please enter the role name.",
		
			role_descrip: "Please enter the role description.",

			cb_role_name: "Please select the group.",

			role_active: "Please select the action.",
		}
	});

	$("#frm_group").validate({
		rules: {
				groups_name: "required",
				group_descrip: "required",
				group_active: "required",
			},

		messages: {
			groups_name: "Please enter the group name.",
		
			group_descrip: "Please enter the group description.",

			group_active: "Please select the group action.",
		}
	});

	$("#frm_privilege").validate({
		rules: {
				privileges_name: "required",
				privilege_descrip: "required",
				sys_mod: "required",
				privilege_active: "required",
			},

		messages: {
			privileges_name: "Please enter the privilege name.",
		
			privilege_descrip: "Please enter the privilege description.",

			sys_mod: "Please select the system module.",
		
			privilege_active: "Please select the privilege action.",

		}
	});

	$("#frm_project").validate({
		rules: {
				projects_name: "required",

				project_descrip: "required",

				project_acronym: "required",

				project_target_end_date: {
					required: true,
					DateFormat : true
				},

				project_actual_end_date: {
					required: true,
					DateFormat : true
				},
				opt_project_status: "required",

				project_active: "required",
			},

		messages: {
			projects_name: "Please enter the project name.",
		
			project_descrip: "Please enter the project description.",

			project_acronym: "Please enter the project acronym.",

			project_target_end_date: {
				required: "Please enter the date of project target end.",
			},
		
			project_actual_end_date: {
				required: "Please enter the date of project actual end.",
			},
			opt_project_status: "Please select the project status.",
		
			project_active: "Please select the project action.",

		}
	});

	$("#frm_project_category").validate({
		rules: {
				project_categories_name: "required",
				project_category_descrip: "required",
				project_category_active: "required",
			},

		messages: {
			project_categories_name: "Please enter the project category name.",
		
			project_category_descrip: "Please enter the project category description.",

			project_category_active: "Please select the project category action.",
		}
	});

	$("#frm_project_version").validate({
		rules: {
				versions_name: "required",
				version_descrip: "required",
				version_active: "required"
			},

		messages: {
			versions_name: "Please enter the version name.",
		
			version_descrip: "Please enter the version description.",

			version_active: "Please select the version action."
		}
	});

	$("#frm_project_module").validate({
		rules: {
				project_modules_name: "required",
				project_module_descrip: "required",
				project_module_active: "required",
			},

		messages: {
			project_modules_name: "Please enter the project modules name.",
		
			project_module_descrip: "Please enter the project modules description.",

			project_module_active: "Please select the project module action.",
		}
	});

	$("#frm_tech").validate({
		rules: {
				tech_name: "required",
				technology_descrip: "required",
				technology_active: "required",
			},

		messages: {
			tech_name: "Please enter the technology name.",
		
			technology_descrip: "Please enter the technology description.",

			technology_active: "Please select the technology action.",

		}
	});

	$("#frm_severity").validate({
		rules: {
				severiti_name: "required",
				severity_descrip: "required",
				severity_active: "required",
			},

		messages: {
			severiti_name: "Please enter the severity name.",
		
			severity_descrip: "Please enter the severity description.",

			severity_active: "Please select the severity action.",

		}
	});

	$("#frm_operating_system").validate({
		rules: {
				operating_system_name: "required",
				operating_system_descrip: "required",
				operating_system_active: "required",
			},

		messages: {
			operating_system_name: "Please enter the operating system name.",
		
			operating_system_descrip: "Please enter the operating system description.",

			operating_system_active: "Please select the operating system action.",

		}
	});

	$("#frm_browser").validate({
		rules: {
				browsers_name: "required",
				browser_descrip: "required",
				browser_active: "required",
			},

		messages: {
			browsers_name: "Please enter the browser name.",
		
			browser_descrip: "Please enter the browser description.",

			browser_active: "Please select the browser action.",

		}
	});

	$("#frm_project_status").validate({
		rules: {
				project_status: "required",
				project_status_descrip: "required",
				project_status_active: "required",
			},

		messages: {
			project_status: "Please enter the project status.",
		
			project_status_descrip: "Please enter the project status description.",

			project_status_active: "Please select the project status action.",
		}
	});

	$("#frm_reproducibility").validate({
		rules: {
				reproducibility: "required",
				reproducibility_descrip: "required",
				reproducibility_active: "required",
			},

		messages: {
			reproducibility: "Please enter the reproducibility.",
		
			reproducibility_descrip: "Please enter the reproducibility description.",

			reproducibility_active: "Please select the reproducibility action.",
		}
	});

	$("#frm_sys_mod").validate({
		rules: {
				sys_mod_name: "required",
				sys_mod_descrip: "required",
				sys_mod_order: "required",
				sys_mod_active: "required",
			},

		messages: {
			sys_mod_name: "Please enter the system module name.",
		
			sys_mod_descrip: "Please enter the system module description.",

			sys_mod_order: "Please enter the system module order.",
		
			sys_mod_active: "Please select the system module action.",

		}
	});

	$("#frm_bug_type").validate({
		rules: {
				bug_type: "required",
				bug_type_descrip: "required",
				bug_type_active: "required",
			},

		messages: {
			bug_type: "Please enter the bug type name.",
		
			bug_type_descrip: "Please enter the bug type description.",
		
			bug_type_active: "Please select the bug type action.",

		}
	});

	$("#frm_report_bugs").validate({
		rules: {
				opt_project: "required",
				opt_version: "required",
				opt_module: "required",
				opt_severity: "required",
				opt_os: "required",
				opt_priority: "required",
				description: "required",
				opt_assign: "required",
				target_date: {
					required: true,
					DateFormat : true
				},
				actual_date: {
					required: true,
					DateFormat : true
				},
				opt_reproducibility: "required",
				opt_bug_type: "required",
			},

		messages: {
				opt_project: "Please select the project.",
				opt_version: "Please select the version.",
				opt_module: "Please select the module.",
				opt_severity: "Please select the severity.",
				opt_os: "Please select the os.",
				opt_priority: "Please select the priority.",
				description: "Please enter the description.",
				opt_assign: "Please select the assign to.",
				target_date: {
					required: "Please enter the date of target resolution.",
				},
				actual_date: {
					required: "Please enter the date of actual resolution.",
				},
				opt_reproducibility: "Please select the reproducibility.",
				opt_bug_type: "Please select the bug type.",
			}
	});

});






