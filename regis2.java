
public class Register extends Activity implements OnClickListener{
    private EditText usu, pass, nomb, rf,cal,est,num_e, num_i, col, loc,del, cod;
    private Button  bReg;


    // Progress Dialog
    private ProgressDialog pDialog;

    // JSON parser class
    JSONParser jsonParser = new JSONParser();

    //si lo trabajan de manera local en xxx.xxx.x.x va su ip local
    // private static final String REGISTER_URL = "http://xxx.xxx.x.x:1234/cas/register.php";

    //testing on Emulator:
    private static final String REGISTER_URL = "http://192.168.1.254/facturacion/insertar_registro.php\n";

    //ids
    private static final String TAG_SUCCESS = "success";
    private static final String TAG_MESSAGE = "message";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        // TODO Auto-generated method stub
        super.onCreate(savedInstanceState);
        setContentView(R.layout.register);

        nomb=(EditText)findViewById(R.id.nombre);
        rf=(EditText)findViewById(R.id.rfc);
        cal=(EditText)findViewById(R.id.calle);
        est=(EditText)findViewById(R.id.estado);
        num_i=(EditText)findViewById(R.id.num_int);
        num_e=(EditText)findViewById(R.id.num_ext);
        col=(EditText)findViewById(R.id.colonia);
        loc=(EditText)findViewById(R.id.localidad);
        del=(EditText)findViewById(R.id.delegacion);
        cod=(EditText)findViewById(R.id.codigo_postal);
        usu=(EditText)findViewById(R.id.usuario);
        pass=(EditText)findViewById(R.id.password);
        bReg=(Button)findViewById(R.id.bRegister);
        bReg.setOnClickListener(this);

    }

    @Override
    public void onClick(View v) {
        // TODO Auto-generated method stub

        new CreateUser().execute();

    }

    class CreateUser extends AsyncTask<String, String, String> {


        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pDialog = new ProgressDialog(Register.this);
            pDialog.setMessage("Creating User...");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... args) {
            // TODO Auto-generated method stub
            // Check for success tag
            int success;
            String nombre=nomb.getText().toString();
            String rfc=rf.getText().toString();
            String calle =cal.getText().toString();
            String estado=est.getText().toString();
            String num_int=num_i.getText().toString();
            String num_ext=num_e.getText().toString();
            String colonia =col.getText().toString();
            String localidad=loc.getText().toString();
            String codigo_postal=cod.getText().toString();
            String usuario=usu.getText().toString();
            String password=pass.getText().toString();

            try {
                // Building Parameters
                List params = new ArrayList();
                params.add(new BasicNameValuePair("user", usuario));
                params.add(new BasicNameValuePair("pass", password));
                params.add(new BasicNameValuePair("nombre", nombre));
                params.add(new BasicNameValuePair("rfc", rfc));
                params.add(new BasicNameValuePair("estado", estado));
                params.add(new BasicNameValuePair("calle", calle));
                params.add(new BasicNameValuePair("colonia", colonia));
                params.add(new BasicNameValuePair("localidad", localidad));
                params.add(new BasicNameValuePair("codigo_postal", codigo_postal));
                params.add(new BasicNameValuePair("num_int", num_int));
                params.add(new BasicNameValuePair("num_ext", num_ext));

                Log.d("request!", "starting");

                //Posting user data to script
                JSONObject json = jsonParser.makeHttpRequest(
                        REGISTER_URL, "POST", params);

                // full json response
                Log.d("Registering attempt", json.toString());

                // json success element
                success = json.getInt(TAG_SUCCESS);
                if (success == 1) {
                    Log.d("User Created!", json.toString());
                    finish();
                    return json.getString(TAG_MESSAGE);
                }else{
                    Log.d("Registering Failure!", json.getString(TAG_MESSAGE));
                    return json.getString(TAG_MESSAGE);

                }
            } catch (JSONException e) {
                e.printStackTrace();
            }

            return null;

        }

        protected void onPostExecute(String file_url) {
            // dismiss the dialog once product deleted
            pDialog.dismiss();
            if (file_url != null){
                Toast.makeText(Register.this, file_url, Toast.LENGTH_LONG).show();
            }
        }
    }
