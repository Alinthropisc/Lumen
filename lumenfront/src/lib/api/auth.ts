import type { LoginPayload, RegisterPayload, AuthTokens } from "@lumen/types";
import type { SuccessResponse } from "@lumen/types";
import { apiClient } from "./client";

export const authApi = {
  login: (data: LoginPayload) =>
    apiClient.post<SuccessResponse<AuthTokens>>("/api/v1/auth/login", data).then((r) => r.data),

  register: (data: RegisterPayload) =>
    apiClient.post<SuccessResponse<AuthTokens>>("/api/v1/auth/register", data).then((r) => r.data),

  refresh: (refreshToken: string) =>
    apiClient
      .post<SuccessResponse<AuthTokens>>("/api/v1/auth/refresh", { refresh_token: refreshToken })
      .then((r) => r.data),

  logout: () => apiClient.post("/api/v1/auth/logout").then((r) => r.data),
};
