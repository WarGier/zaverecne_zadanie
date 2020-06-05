

pkg load control


arguments = argv();

r= str2double(arguments{1});




function ret = plane(r)

%http://ctms.engin.umich.edu/CTMS/index.php?example=AircraftPitch&section=ControlStateSpace

A = [-0.313 56.7 0; -0.0139 -0.426 0; 0 56.7 0];
B = [0.232; 0.0203; 0];
C = [0 0 1];
D = [0];

p = 2;
K = lqr(A,B,p*C'*C,1);
N = -inv(C(1,:)*inv(A-B*K)*B);

sys = ss(A-B*K, B*N, C, D);

t = 0:0.1:40;
r =0.2;
initAlfa=0;
initQ=0;
initTheta=0;
[y,t,x]=lsim(sys,r*ones(size(t)),t,[initAlfa;initQ;initTheta]);
plot(t,y)

r =0.5;
[y,t,x]=lsim(sys,r*ones(size(t)),t,x(size(x,1),:));
plot(t,y)

plot(t,r*ones(size(t))*N-x*K')


ret = [x(:,3), r*ones(size(t))*N-x*K'];
endfunction

disp(plane(r));