  <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('employees', function (Blueprint $table) {
                $table->id();

                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('email', 228);
                $table->string('phone')->nullable();
                $table->decimal('salary', 11, 2)->nullable();
                $table->string('photo')->nullable();
                $table->string('address', 2000)->nullable();
                $table->date('hiring_date');
                $table->date('joining_date');
                $table->integer('sorting')->default(1);
                $table->unsignedBigInteger('department_id')->nullable();
                $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
                $table->unsignedBigInteger('designation_id')->nullable();
                $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
                
                $table->enum('status', ['Active', 'Inactive', 'Deleted'])->default('Active');
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('employees');
        }
    };
