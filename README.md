=== Plugin Info ===
Setup My Technology — SMPLFY SMT
Repo: simplifybiz-smt

Custom plugin for the Setup My Technology site. Built on the SMPLFY
architecture (Repositories / Usecases / Adapters).

Depends on: smplfy-core

=== Features ===
- Branded form confirmations for Get An Estimate (Form 3) and Job Master (Form 6)
- MemberPress auto-enrollment on user registration (admin + Gravity Forms)
- All site CSS managed via public/css/frontend.css
- Entity mapping for all SMT form fields
- Repositories for CRUD operations on form entries

=== Architecture ===
smplfy-smt.php                    Main plugin file / entry point
admin/DependencyFactory.php       Wires up dependencies
admin/utilities/                  Require helpers (generic)
includes/smplfy_bootstrap.php     Loads files + kicks off factory
includes/enqueue_scripts.php      Enqueues frontend CSS
public/css/frontend.css           All site-wide CSS
public/php/types/                 FormIds (reference data)
public/php/entities/              GetAnEstimateEntity, JobMasterEntity
public/php/repositories/          GetAnEstimateRepository, JobMasterRepository
public/php/usecases/              MemberPressAutoEnroll
public/php/adapters/              GravityFormsAdapter, WordpressAdapter
